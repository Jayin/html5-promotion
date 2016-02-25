main:
	@echo "hello world!!"

init-deploy-environment:
	-mkdir ./Application/Runtime
	chmod 777 ./Application/Runtime
	chmod 777 ./Project_dev


.PHONY: main init-deploy-environment

