# ------------------------------------------------------------------------------
# Server
# ------------------------------------------------------------------------------
set :application,				"Tobias Wooldridge's Blog"
set :domain,     				"119.252.20.55"

role :web,       				domain                         # Your HTTP server, Apache/etc
role :app,       				domain                         # This may be the same as your `Web` server
role :db,        				domain, :primary => true       # This is where Symfony2 migrations will run

# ------------------------------------------------------------------------------
# SCM
# ------------------------------------------------------------------------------
set :deploy_to,   				"/var/www/tobias.wooldridge.id.au"

set :scm,         				:git
set :repository,  				"git://github.com/TobiasWooldridge/blog.git"
set :keep_releases, 				3


# ------------------------------------------------------------------------------
# User stuff
# ------------------------------------------------------------------------------

set :use_sudo, false
set :user,			      		"blog"
set :webserver_user,      			"www-data"
set :permission_method,   			:acl
set :writable_dirs,       			["app/cache", "app/logs", "web/file"]
set :use_set_permissions,			true

# ------------------------------------------------------------------------------
# Project
# ------------------------------------------------------------------------------
set :model_manager, 				"doctrine"
set :app_path,    				"app"

set :shared_children, 				[app_path + "/logs", app_path + "/var", "web/file"]
set :shared_files,      			[app_path + "/config/parameters.yml"]

set :use_composer,				true
set :composer_options,  			"--verbose --prefer-dist"

set :dump_assetic_assets,			true


# ------------------------------------------------------------------------------
# Hacks and stuff
# ------------------------------------------------------------------------------

# Restart nginx to clear its cache
namespace :deploy do
  after "deploy:create_symlink" do
  	capifony_pretty_print "--> Restarting nginx"
    run "sudo service nginx restart"
    capifony_puts_ok
  end
end
