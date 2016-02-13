load 'deploy' if respond_to?(:namespace) # cap2 differentiator
Dir['plugins/*/lib/recipes/*.rb'].each { |plugin| load(plugin) }
load Gem.find_files('capifony_symfony1.rb').first.to_s

set :stages,        %w(production staging)
set :default_stage, "staging"
require 'capistrano/ext/multistage'

set :application, "parquelareja"
set :repository,  "https://github.com/diegodorado/parquelareja.git"
set :scm,         :git

set  :keep_releases,  3
set :web_path,           "web"


task :uname do
  run "uname -a"
end

before "deploy:create_symlink" do
  run "mv #{latest_release}/web/frontend_prod.php  #{latest_release}/web/index.php"
end

namespace :database do
  desc "Restores last backup"
  task :restore, :roles => :db , :only => { :primary => true }  do

    zipped_file_path  = `readlink backups/#{application}.remote_dump.latest.sql.gz`.chop  # gunzip does not work with a symlink
    unzipped_file_path   = "backups/#{application}_dump.sql"

    run_locally "gunzip -c backups/#{zipped_file_path} > #{unzipped_file_path}"

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

  desc "Push local dump to remote & populate there"
  task :push_dump, :roles => :db, :only => { :primary => true } do

    filename  = "#{application}.remote_dump.latest.sql.gz"
    file      = "backups/#{filename}"
    sqlfile   = "#{application}_dump.sql"
    config    = ""

    upload(file, "#{remote_tmp_dir}/#{filename}", :via => :scp)
    run "#{try_sudo} gunzip -c #{remote_tmp_dir}/#{filename} > #{remote_tmp_dir}/#{sqlfile}"

    run "#{try_sudo} cat #{shared_path}/config/databases.yml" do |ch, st, data|
      config = load_database_config data, symfony_env_prod
    end

    try_sudo generate_sql_command('drop', config)
    try_sudo generate_sql_command('create', config)

    sql_import_cmd = generate_sql_command('import', config)

    try_sudo "#{sql_import_cmd} < #{remote_tmp_dir}/#{sqlfile}"

    run "#{try_sudo} rm #{remote_tmp_dir}/#{filename}"
    run "#{try_sudo} rm #{remote_tmp_dir}/#{sqlfile}"
  end

end


after "deploy:update_code" do
  # Fix permissions
  run "cd #{latest_release} && find * -type f -exec chmod 644 {} \\;"
  run "cd #{latest_release} && find * -type d -exec chmod 755 {} \\;"
end

namespace :symfony do
  namespace :doctrine do
    task :build_classes do
      #run "#{try_sudo} sh -c 'cd #{latest_release} && #{php_bin} ./symfony doctrine:build --all-classes --env=#{symfony_env_prod}'"
    end
  end
end
