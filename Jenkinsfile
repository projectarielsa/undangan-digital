pipeline {
    agent any

    environment {
        APP_DIR = "/srv/apps/undangan-prod"
        SERVICE = "app"
    }

    stages {

        stage('Deploy Production (FAST SAFE)') {
            steps {
                sh '''
                    set -e

                    cd $APP_DIR

                    echo "🔐 Safe directory git"
                    git config --global --add safe.directory $APP_DIR

                    echo "📥 Pull latest code"
                    git pull origin main

                    echo "🛑 Stop container"
                    docker compose down || true

                    echo "🚀 Start container (NO FULL REBUILD)"
                    docker compose up -d --build --remove-orphans

                    echo "✅ Container started"
                '''
            }
        }

        stage('Laravel Optimize') {
            steps {
                sh '''
                    set -e

                    cd $APP_DIR

                    echo "📦 Get container ID"
                    CONTAINER=$(docker compose ps -q $SERVICE)

                    if [ -z "$CONTAINER" ]; then
                        echo "❌ Container app tidak ditemukan"
                        exit 1
                    fi

                    echo "⚙️ Fix safe directory inside container"
                    docker exec $CONTAINER git config --global --add safe.directory /var/www/html || true

                    echo "🧹 Clear Laravel cache"
                    docker exec $CONTAINER php artisan optimize:clear || true

                    echo "📦 Composer optimize"
                    docker exec $CONTAINER composer dump-autoload --optimize || true

                    echo "🔗 Storage link"
                    docker exec $CONTAINER php artisan storage:link || true
                '''
            }
        }

    }

    post {
        success {
            echo "🎉 Production deploy SUCCESS"
        }
        failure {
            echo "❌ Production deploy FAILED"
        }
    }
}