pipeline {
  agent any
  stages {
    stage("Checkout") {
      steps {
        git(url: 'https://github.com/alfianchii/confess', branch: 'main')
      }
    }

    stage("Log") {
      steps {
        sh 'ls -la'
      }
    }

    stage('Setup') {
      steps {
        sh '''
          docker compose -f ./docker-compose.prod.yaml up -d --build
          docker compose run --rm artisan key:generate
          docker compose run --rm artisan config:cache
          docker compose run --rm artisan event:cache
          docker compose run --rm artisan view:cache
        '''
      }
    }

    stage('Deps') {
      steps {
        sh '''
          docker compose run --rm composer install --optimize-autoloader --no-dev
          docker compose run --rm npm install
        '''
      }
    }

    stage('Build') {
      steps {
        sh 'docker compose run --rm npm run build'
      }
    }
  }
}