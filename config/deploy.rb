#################
#   CONFIG
################
ssh_options[:forward_agent] = true
set :use_sudo, false

set :application, "Severine"
set :domain, 'vps20377.ovh.net'
set :port, '1368'
set :applicationdir, "/var/www/PhpstormProjects/severine"



#################
#   GITHUB
################
set :repository, "git@github.com:clempat/severine.git"
set :scm, "git"
set :branch, 'master'
set :git_shallow_clone, 1

#################
#   SERVEUR
################
role :web, domain
role :app, domain
role :db,  domain, :primary => true
set :user, "clempat"

set :deploy_to, applicationdir
set :deploy_via, :export

default_run_options[:pty] = true

# if you want to clean up old releases on each deploy uncomment this:
# after "deploy:restart", "deploy:cleanup"

# if you're still using the script/reaper helper you will need
# these http://github.com/rails/irs_process_scripts

# If you are using Passenger mod_rails uncomment this:
namespace :deploy do
   task :start do ; end
   task :stop do ; end
   task :restart, :roles => :app, :except => { :no_release => true } do
     run "#{try_sudo} touch #{File.join(current_path,'tmp','restart.txt')}"
   end
end