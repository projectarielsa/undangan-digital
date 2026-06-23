pipeline {
agent any

stages {

    stage('1. Deploy Undangan STAGING') {
        steps {
            script {
                echo '🚀 Deploy Undangan Digital STAGING'

                sh '''
                    set -e

                    cd /srv/apps/undangan-stg

                    # Fix Git ownership warning
                    git config --global --add safe.directory /srv/apps/undangan-stg

                    echo "📥 Update source code..."
                    git fetch --all
                    git reset --hard origin/develop

                    # Validasi .env
                    if [ ! -f .env ]; then
                        echo "❌ File .env tidak ditemukan"
                        exit 1
                    fi

                    # Deteksi docker compose command
                    if docker compose version >/dev/null 2>&1; then
                        COMPOSE="docker compose"
                    elif command -v docker-compose >/dev/null 2>&1; then
                        COMPOSE="docker-compose"
                    else
                        echo "❌ Docker Compose tidak ditemukan"
                        exit 1
                    fi

                    echo "Menggunakan: $COMPOSE"

                    echo "🛑 Stop container lama..."
                    $COMPOSE down || true

                    echo "🔨 Build image baru..."
                    $COMPOSE build --no-cache

                    echo "🚀 Start container..."
                    $COMPOSE up -d
                '''
            }
        }
    }

    stage('2. Laravel Optimization') {
        steps {
            script {
                echo '⚙️ Optimasi Laravel'

                sh '''
                    set -e

                    cd /srv/apps/undangan-stg

                    # Deteksi docker compose command
                    if docker compose version >/dev/null 2>&1; then
                        COMPOSE="docker compose"
                    elif command -v docker-compose >/dev/null 2>&1; then
                        COMPOSE="docker-compose"
                    else
                        echo "❌ Docker Compose tidak ditemukan"
                        exit 1
                    fi

                    APP_CONTAINER=$($COMPOSE ps -q app)

                    if [ -z "$APP_CONTAINER" ]; then
                        echo "❌ Container app tidak ditemukan"
                        exit 1
                    fi

                    echo "📦 Container: $APP_CONTAINER"

                    docker exec -t $APP_CONTAINER rm -f \
                        bootstrap/cache/config.php \
                        bootstrap/cache/packages.php \
                        bootstrap/cache/services.php || true

                    docker exec -t $APP_CONTAINER composer dump-autoload --optimize --no-scripts

                    docker exec -t $APP_CONTAINER php artisan package:discover --ansi

                    docker exec -t $APP_CONTAINER php artisan migrate --force

                    docker exec -t $APP_CONTAINER php artisan storage:link || true

                    docker exec -t $APP_CONTAINER php artisan optimize
                '''
            }
        }
    }
}

post {
    success {
        echo '🎉 Deploy Undangan STAGING berhasil'
    }

    failure {
        echo '❌ Deploy Undangan STAGING gagal'
    }
}

}
