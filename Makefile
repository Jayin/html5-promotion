CHANGE_MODE_FILE=./Application/Runtime ./Project ./Project_dev ./Package

main:
	@echo "hello world!!"

init-deploy-environment:
	-mkdir ./Application/Runtime
	chmod 777 $(CHANGE_MODE_FILE)


.PHONY: main init-deploy-environment

