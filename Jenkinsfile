pipeline {
    agent any

    stages {

        stage('1. Deploy Undangan STAGING') {
            steps {
                script {
                    echo '🚀 Deploy Undangan Digital STAGING'

                    sh '''
                        cd /srv/apps/undangan-stg

                        # Ambil source terbaru
                        git fetch --all
                        git reset --hard origin/main

                        # Pastikan .env aman
                        if [ ! -f .env ]; then
                            echo ".env tidak ditemukan!"
                            exit 1
                        fi

                        # Rebuild container
                        docker compose down --remove-orphans || true
                        docker compose build --no-cache
                        docker compose up -d
                    '''
                }
            }
        }

        stage('2. Laravel Optimization') {
            steps {
                script {
                    echo '⚙️ Optimasi Laravel'

                    sh '''
                        cd /srv/apps/undangan-stg

                        APP_CONTAINER=$(docker compose ps -q app)

                        docker exec -t $APP_CONTAINER rm -f \
                            bootstrap/cache/config.php \
                            bootstrap/cache/packages.php \
                            bootstrap/cache/services.php || true

                        docker exec -t $APP_CONTAINER composer dump-autoload --optimize --no-scripts

                        docker exec -t $APP_CONTAINER php artisan package:discover --ansi

                        docker exec -t $APP_CONTAINER php artisan migrate --force

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