pipeline {
  agent any
  stages {
    stage('Verification') {
      steps {
        validateDeclarativePipeline 'Jenkinsfile'
        sh 'php -v'
      }
    }

    stage('installer') {
      parallel {
        stage('Build') {
          environment {
            DB_HOST = credentials('DB-Host')
            DB_USERNAME = credentials('DB_user')
            DB_PASSWORD = credentials('DB_PASS')
          }
          steps {
            sh 'php --version'
            sh 'composer install'
            sh 'composer --version'
            sh 'cp .env.example .env'
            sh 'echo DB_HOST=${DB_HOST} >> .env'
            sh 'echo DB_USERNAME=${DB_USERNAME} >> .env'
            sh 'echo DB_DATABASE=pre_BCFD >> .env'
            sh 'echo DB_PASSWORD=${DB_PASSWORD} >> .env'
            sh 'php artisan key:generate'
            sh 'cp .env .env.testing'
            sh 'php artisan migrate'
          }
        }

        stage('Début de l\'analyse') {
          steps {
             def scannerHome = tool 'sonar';
            withSonarQubeEnv(installationName: 'Serveur sonarqube', credentialsId: 'sonarqube_access_token') {
              sh '${scannerHome}/bin/sonar-scanner'
            }

          }
        }

      }
    }

    stage('Unit test') {
      steps {
        sh 'php artisan test'
      }
    }

    stage('Static analyst') {
      steps {
        sh 'vendor/bin/phpstan analyse --memory-limit=2G'
        sh 'vendor/bin/phpcs .\\app\\Http\\Controllers\\'
      }
    }

  }
}
