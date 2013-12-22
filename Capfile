load 'deploy' if respond_to?(:namespace) # cap2 differentiator
Dir['plugins/*/lib/recipes/*.rb'].each { |plugin| load(plugin) }

load Gem.find_files('capifony_symfony1.rb').first.to_s


=begin
set :application, "fundacion-sancor"
set :domain,      "fsancor.cooph.com.ar"
set :deploy_to,   "/home/hormigon/#{application}"
set :use_sudo, false
set :user, 'hormigon'
=end

set :application, "parquelareja"
set :domain,      "190.210.151.78"
set :deploy_to,   "/home/ddorado/#{application}"
set :use_sudo, false
set :user, 'ddorado'

set :deploy_via, :remote_cache

set :repository,  "git://github.com/diegodorado/#{application}.git"
set :scm,         :git

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where symfony migrations will run

set  :keep_releases,  3

before "deploy:create_symlink" do
  run "mv #{latest_release}/web/frontend_prod.php  #{latest_release}/web/index.php"
end

namespace :database do
  desc "Restores last backup"
  task :restore, :roles => :db , :only => { :primary => true }  do

    begin
      zipped_file_path  = `readlink -f backups/#{application}.remote_dump.latest.sql.gz`.chop  # gunzip does not work with a symlink
    rescue Exception # fallback for file systems that don't support symlinks
      zipped_file_path  = "backups/#{application}.remote_dump.latest.sql.gz"
    end
    unzipped_file_path   = "backups/#{application}_dump.sql"

    run_locally "gunzip -c #{zipped_file_path} > #{unzipped_file_path}"

    config = load_database_config IO.read('config/databases.yml'), symfony_env_local

    cmd = "mysql -f -u#{config["user"]} -p#{config["pass"]} -e \"DROP DATABASE IF EXISTS #{config["db"]} \" "
    cmd += " --host=#{config["host"]}" if config["host"]
    cmd += " --port=#{config["port"]}" if config["port"]
    run_locally cmd
    run_locally generate_sql_command('create', config)

    sql_import_cmd = generate_sql_command('import', config)
    run_locally "#{sql_import_cmd} < #{unzipped_file_path}"

    run_locally "rm #{unzipped_file_path}"
  end
  
  desc "Loads dump sql file located at data/dump.sql"
  task :create, :roles => :db , :only => { :primary => true }  do

    file_path   = "data/dump.sql"

    config = load_database_config IO.read('config/databases.yml'), symfony_env_local

    cmd = "mysql -f -u#{config["user"]} -p#{config["pass"]} -e \"DROP DATABASE IF EXISTS #{config["db"]} \" "
    cmd += " --host=#{config["host"]}" if config["host"]
    cmd += " --port=#{config["port"]}" if config["port"]
    run_locally cmd
    run_locally generate_sql_command('create', config)

    sql_import_cmd = generate_sql_command('import', config)
    run_locally "#{sql_import_cmd} < #{file_path}"

  end  
  
end
