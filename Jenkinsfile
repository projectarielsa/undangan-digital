pipeline {
    agent any

    stages {

        stage('Deploy Production') {
            steps {
                sh '''
                    set -e

                    cd /srv/apps/undangan-prod

                    git config --global --add safe.directory /srv/apps/undangan-prod

                    echo "📥 Pull latest code..."
                    git pull origin main

                    echo "🛑 Stop container..."
                    docker compose down || true

                    echo "🔨 Build..."
                    docker compose build

                    echo "🚀 Start..."
                    docker compose up -d
                '''
            }
        }

        stage('Laravel Optimize') {
            steps {
                sh '''
                    cd /srv/apps/undangan-prod

                    CONTAINER=$(docker compose ps -q app)

                    if [ -z "$CONTAINER" ]; then
                        echo "Container app tidak ditemukan"
                        exit 1
                    fi

                    docker exec $CONTAINER php artisan optimize:clear || true
                    docker exec $CONTAINER composer dump-autoload --optimize
                    docker exec $CONTAINER php artisan storage:link || true
                '''
            }
        }
    }

    post {
        success {
            echo "✅ Production deploy sukses"
        }
        failure {
            echo "❌ Deploy gagal"
        }
    }
}