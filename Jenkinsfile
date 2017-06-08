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
                // sh('composer install')
            }

            stage('test') {
                // sh('./vendor/bin/phpunit')
            }
        
            stage('documentation') {
                sh('php phpDocumentor.phar -d app -t public/docs --template="responsive-twig"')
                publishHTML([
                    allowMissing: false, 
                    alwaysLinkToLastBuild: true, 
                    keepAll: true, 
                    reportDir: WORKSPACE+'/public/docs', 
                    reportFiles: 'index.html', 
                    reportName: 'PHPDocumentor Report', 
                    reportTitles: ''
                ])
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
                        sh('git config git-ftp.url ftp://46.105.92.169/test/')
                        sh('git config git-ftp.password ${FTP_PASSWORD}')
                        
                        sh('git ftp catchup')
                        
                        sh('git ftp init'
                        
                        sh('git ftp push')
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
            deleteDir()
        }
    }
}
