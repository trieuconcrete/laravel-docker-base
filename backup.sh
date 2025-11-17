#!/bin/bash

# Database backup script

BACKUP_DIR="./backups"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_FILE="laravel_backup_$TIMESTAMP.sql"

# Create backup directory if not exists
mkdir -p $BACKUP_DIR

echo "=========================================="
echo "Laravel Database Backup"
echo "=========================================="
echo ""
echo "Creating backup: $BACKUP_FILE"
echo ""

# Create backup
docker-compose exec -T mysql mysqldump -u laravel -psecret laravel > "$BACKUP_DIR/$BACKUP_FILE"

if [ $? -eq 0 ]; then
    echo "✅ Backup created successfully!"
    echo "Location: $BACKUP_DIR/$BACKUP_FILE"
    
    # Compress backup
    gzip "$BACKUP_DIR/$BACKUP_FILE"
    echo "✅ Backup compressed: $BACKUP_FILE.gz"
    
    # Show backup size
    size=$(du -h "$BACKUP_DIR/$BACKUP_FILE.gz" | cut -f1)
    echo "Size: $size"
    
    # Keep only last 10 backups
    echo ""
    echo "Cleaning old backups (keeping last 10)..."
    ls -t $BACKUP_DIR/laravel_backup_*.sql.gz | tail -n +11 | xargs -r rm
    
    echo ""
    echo "Current backups:"
    ls -lh $BACKUP_DIR/laravel_backup_*.sql.gz 2>/dev/null || echo "No backups found"
else
    echo "❌ Backup failed!"
    exit 1
fi

echo ""
echo "=========================================="
echo "To restore a backup, run:"
echo "  ./restore.sh $BACKUP_DIR/$BACKUP_FILE.gz"
echo "=========================================="
