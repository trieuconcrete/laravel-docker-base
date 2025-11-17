#!/bin/bash

# Database restore script

if [ -z "$1" ]; then
    echo "Usage: ./restore.sh <backup_file.sql.gz>"
    echo ""
    echo "Available backups:"
    ls -lh backups/laravel_backup_*.sql.gz 2>/dev/null || echo "No backups found"
    exit 1
fi

BACKUP_FILE=$1

if [ ! -f "$BACKUP_FILE" ]; then
    echo "Error: Backup file not found: $BACKUP_FILE"
    exit 1
fi

echo "=========================================="
echo "Laravel Database Restore"
echo "=========================================="
echo ""
echo "⚠️  WARNING: This will replace the current database!"
echo "Backup file: $BACKUP_FILE"
echo ""
read -p "Are you sure you want to continue? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "Restore cancelled."
    exit 0
fi

echo ""
echo "Decompressing backup..."
gunzip -c "$BACKUP_FILE" > /tmp/restore.sql

echo "Restoring database..."
docker-compose exec -T mysql mysql -u laravel -psecret laravel < /tmp/restore.sql

if [ $? -eq 0 ]; then
    echo "✅ Database restored successfully!"
    rm /tmp/restore.sql
else
    echo "❌ Restore failed!"
    rm /tmp/restore.sql
    exit 1
fi

echo ""
echo "=========================================="
echo "Restore Complete"
echo "=========================================="
