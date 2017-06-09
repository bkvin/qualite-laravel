node("master") {
    try {
        def IS_MODIFIED = false
        
        stage('prepare') {
            git credentialsId: '9960d055-df1c-474a-ac3b-5bfdfbd4d59d', url: 'https://github.com/bkvin/qualite-laravel.git', branch: 'master'

            GIT_MERGE = sh(returnStdout: true, script: 'git merge origin/dev').trim()
            echo GIT_MERGE
            
            if (GIT_MERGE != "Already up-to-date.") { 
               IS_MODIFIED = true
            }
        }

        if(IS_MODIFIED){

            stage('build'){ 
                sh('composer update')
            }

            stage('test') {
                sh('php artisan config:cache')
                sh('./vendor/bin/phpunit')
                sh('./vendor/bin/behat')
                sh('./vendor/bin/phpcpd app')
            }
        
            stage('documentation') {
                sh('php phpDocumentor.phar -d app -t public/docs --template="responsive-twig"')
            }

            stage('git'){              
                sh('git add . && git commit -m "Jenkins phpDocumentor & merge branch origin/dev"')
                withCredentials([[$class: 'UsernamePasswordMultiBinding', credentialsId: '9960d055-df1c-474a-ac3b-5bfdfbd4d59d', usernameVariable: 'GIT_USERNAME', passwordVariable: 'GIT_PASSWORD']]) {

                    sh('git push https://${GIT_USERNAME}:${GIT_PASSWORD}@github.com/bkvin/qualite-laravel.git')
                }          
            }
            
            stage('deploy'){  
            
                withCredentials([[$class: 'UsernamePasswordMultiBinding', credentialsId: 'cd435227-8d21-43c6-ad40-7a24dff92abd', usernameVariable: 'FTP_USERNAME', passwordVariable: 'FTP_PASSWORD']]) {
                    
                    if(IS_MODIFIED) {
                        sh('git config git-ftp.user ${FTP_USERNAME}')
                        sh('git config git-ftp.url ftp://46.105.92.169/wordpress/test/')
                        sh('git config git-ftp.password ${FTP_PASSWORD}')

                        try {
                            sh('git ftp push')
                        } catch(error) {
                            sh('git ftp init')
                        }
                    }
                }
            }
        }
    } catch(error) {
        throw error
    } finally {
    
        stage('cleanup') {
            // Recursively delete all files and folders in the workspace
            // using the built-in pipeline command
            cleanWs()
        }
    }
}

