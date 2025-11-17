.PHONY: help build up down restart logs shell composer artisan migrate fresh seed test npm

help: ## Hiển thị help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

build: ## Build containers
	docker-compose build

up: ## Khởi động containers
	docker-compose up -d

down: ## Dừng containers
	docker-compose down

restart: ## Restart containers
	docker-compose restart

logs: ## Xem logs
	docker-compose logs -f

ps: ## Xem container status
	docker-compose ps

shell: ## Truy cập vào app container
	docker-compose exec app bash

nginx-shell: ## Truy cập vào nginx container
	docker-compose exec nginx sh

mysql-shell: ## Truy cập vào MySQL
	docker-compose exec mysql mysql -u laravel -psecret laravel

redis-shell: ## Truy cập vào Redis CLI
	docker-compose exec redis redis-cli

composer: ## Chạy composer (ví dụ: make composer cmd="install")
	docker-compose exec app composer $(cmd)

artisan: ## Chạy artisan (ví dụ: make artisan cmd="migrate")
	docker-compose exec app php artisan $(cmd)

migrate: ## Chạy migrations
	docker-compose exec app php artisan migrate

fresh: ## Fresh migrate với seed
	docker-compose exec app php artisan migrate:fresh --seed

seed: ## Chạy seeders
	docker-compose exec app php artisan db:seed

test: ## Chạy tests
	docker-compose exec app php artisan test

npm: ## Chạy npm (ví dụ: make npm cmd="install")
	docker-compose exec app npm $(cmd)

cache-clear: ## Clear cache
	docker-compose exec app php artisan cache:clear
	docker-compose exec app php artisan config:clear
	docker-compose exec app php artisan route:clear
	docker-compose exec app php artisan view:clear

optimize: ## Optimize application
	docker-compose exec app php artisan config:cache
	docker-compose exec app php artisan route:cache
	docker-compose exec app php artisan view:cache

perm: ## Fix permissions
	docker-compose exec app chown -R www:www /var/www/html/storage
	docker-compose exec app chown -R www:www /var/www/html/bootstrap/cache
	docker-compose exec app chmod -R 775 /var/www/html/storage
	docker-compose exec app chmod -R 775 /var/www/html/bootstrap/cache

install-laravel: ## Cài đặt Laravel 12 mới
	docker-compose up -d
	@echo "Đang cài đặt Laravel 12..."
	docker-compose exec app composer create-project laravel/laravel . --prefer-dist
	docker-compose exec app cp .env.example .env || cp .env.example src/.env
	docker-compose exec app php artisan key:generate
	@echo "Đang cấu hình database..."
	@make configure-env
	@echo "Chạy migrations..."
	docker-compose exec app php artisan migrate
	@make perm
	@echo "✅ Cài đặt hoàn tất!"
	@echo "🌐 Truy cập: http://localhost:8000"
	@echo "📧 Mailhog: http://localhost:8025"

configure-env: ## Cấu hình .env với Docker services
	@docker-compose exec app sed -i 's/DB_HOST=127.0.0.1/DB_HOST=mysql/g' .env 2>/dev/null || true
	@docker-compose exec app sed -i 's/DB_DATABASE=laravel/DB_DATABASE=laravel/g' .env 2>/dev/null || true
	@docker-compose exec app sed -i 's/DB_USERNAME=root/DB_USERNAME=laravel/g' .env 2>/dev/null || true
	@docker-compose exec app sed -i 's/DB_PASSWORD=/DB_PASSWORD=secret/g' .env 2>/dev/null || true
	@docker-compose exec app sed -i 's/REDIS_HOST=127.0.0.1/REDIS_HOST=redis/g' .env 2>/dev/null || true
	@docker-compose exec app sed -i 's/CACHE_STORE=.*/CACHE_STORE=redis/g' .env 2>/dev/null || true
	@docker-compose exec app sed -i 's/SESSION_DRIVER=.*/SESSION_DRIVER=redis/g' .env 2>/dev/null || true
	@docker-compose exec app sed -i 's/QUEUE_CONNECTION=.*/QUEUE_CONNECTION=redis/g' .env 2>/dev/null || true
	@docker-compose exec app sed -i 's/MAIL_HOST=.*/MAIL_HOST=mailhog/g' .env 2>/dev/null || true
	@docker-compose exec app sed -i 's/MAIL_PORT=.*/MAIL_PORT=1025/g' .env 2>/dev/null || true

setup: ## Setup project lần đầu (Laravel đã có sẵn trong src/)
	@if [ ! -f "src/artisan" ]; then \
		echo "❌ Không tìm thấy Laravel trong thư mục src/"; \
		echo "Chạy 'make install-laravel' để cài đặt Laravel mới"; \
		echo "hoặc copy source Laravel vào thư mục src/"; \
		exit 1; \
	fi
	docker-compose up -d
	@echo "⏳ Đợi containers khởi động..."
	@sleep 5
	docker-compose exec app composer install
	@if [ ! -f "src/.env" ]; then \
		docker-compose exec app cp .env.example .env; \
		docker-compose exec app php artisan key:generate; \
	fi
	@make configure-env
	docker-compose exec app php artisan migrate
	@make perm
	@echo "✅ Setup hoàn tất!"
	@echo "🌐 Application: http://localhost:8000"
	@echo "📧 Mailhog UI: http://localhost:8025"
