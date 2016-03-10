CHANGE_MODE_FILE=./Application/Runtime ./Project ./Project_dev ./Package
REMOTE=api.fenxiangbei.com
REMOTE_DIR=/var/www/h5/html5-promotion

main:
	@echo "hello world!!"

init-deploy-environment:
	-mkdir ./Application/Runtime
	chmod 777 $(CHANGE_MODE_FILE)

update-project:
	git submodule update --remote Project
	git add Project 
	git commit -m 'Uprgrade `Project/` at $(shell date)'
	
mirror:
	-git pull origin develop
	-git remote add github git@github.com:Jayin/html5-promotion.git
	-git push github develop
	
init-rsync:
	rsync -r -P ./ root@$(REMOTE):$(REMOTE_DIR)

.PHONY: main init-deploy-environment update-html5-promotion-project mirror

