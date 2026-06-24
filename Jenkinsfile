pipeline {
agent any

stages {

    stage('Deploy PRODUCTION') {
        steps {
            sh '''
                set -e

                cd /srv/apps/undangan-prod

                git config --global --add safe.directory /srv/apps/undangan-prod

                echo "📥 Pull latest code"
                git pull origin main

                echo "🛑 Stop container"
                docker-compose -f docker/docker-compose.prod.yml down || true

                echo "🚀 Build & Start"
                docker-compose -f docker/docker-compose.prod.yml up -d --build

                docker exec $CONTAINER chown -R www-data:www-data storage bootstrap/cache

                docker exec $CONTAINER chmod -R 775 storage bootstrap/cache
                
                docker exec $CONTAINER php artisan optimize:clear
            '''
        }
    }

    stage('Laravel Optimize') {
        steps {
            sh '''
                set -e

                cd /srv/apps/undangan-prod

                CONTAINER=$(docker-compose -f docker/docker-compose.prod.yml ps -q app)

                if [ -z "$CONTAINER" ]; then
                    echo "Container app tidak ditemukan"
                    exit 1
                fi

                docker exec $CONTAINER git config --global --add safe.directory /var/www/html || true

                docker exec $CONTAINER php artisan optimize:clear || true
                docker exec $CONTAINER composer dump-autoload --optimize || true
                docker exec $CONTAINER php artisan storage:link || true
            '''
        }
    }
}

post {
    success {
        echo "🚀 PRODUCTION SUCCESS"
    }

    failure {
        echo "❌ PRODUCTION FAILED"
    }
}

}
