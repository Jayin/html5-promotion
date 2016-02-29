CHANGE_MODE_FILE=./Application/Runtime ./Project ./Project_dev ./Package

main:
	@echo "hello world!!"

init-deploy-environment:
	-mkdir ./Application/Runtime
	chmod 777 $(CHANGE_MODE_FILE)

update-project:
	git submodule update --remote Project
	git add Project 
	git commit -m 'Uprgrade `Project/` at $(shell date)'

.PHONY: main init-deploy-environment update-html5-promotion-project

