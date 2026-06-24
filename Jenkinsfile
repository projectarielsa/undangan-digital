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
                    docker-compose -p undangan-prod -f docker/docker-compose.prod.yml down || true

                    echo "🚀 Build & Start"
                    docker-compose -p undangan-prod -f docker/docker-compose.prod.yml up -d --build
                '''
            }
        }

        stage('Laravel Optimize') {
            steps {
                sh '''
                    set -e

                    cd /srv/apps/undangan-prod

                    CONTAINER=$(docker-compose -p undangan-prod -f docker/docker-compose.prod.yml ps -q app)

                    docker exec $CONTAINER php artisan optimize:clear || true
                    docker exec $CONTAINER composer dump-autoload --optimize || true
                    docker exec $CONTAINER php artisan storage:link || true
                '''
            }
        }
    }
}