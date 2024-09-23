pipeline {
    agent any
    stages {
        stage('Install Dependencies') {
            steps {
                script {
                    sh 'composer install'
                }
            }
        }
        stage('Run Tests') {
            steps {
                script {
                    sh 'vendor/bin/phpunit'
                }
            }
        }
        stage('Build Docker Image') {
            steps {
                script {
                    dockerImage = docker.build("usuario/nome-da-imagem:${env.BUILD_ID}")
                }
            }
        }
        stage('Deploy') {
            steps {
                script {
                    // Aqui você pode adicionar comandos para implantar a imagem
                    echo 'Deploying...'
                }
            }
        }
    }
    post {
        always {
            junit 'tests/Results/*.xml'
        }
    }
}
