APP_NAME=LessonComposer01
APP_IMG=php-lesson-composer01
APP_CONTAINER=LessonComposer01

build:
	@echo 'Build image from Dokerfile ($(APP_IMG))'
	@sudo docker build -t $(APP_IMG) .
	@echo 'End build'

run:
	@echo 'Run $(APP_CONTAINER) on $(APP_IMG)'
	@sudo docker run -d -P -v $(PWD):/usr/src/$(APP_NAME) --link mysql --name $(APP_CONTAINER) $(APP_IMG)
	@sudo docker ps -f name=$(APP_CONTAINER)

start:
	@sudo docker start $(APP_CONTAINER)
	@sudo docker ps -f name=$(APP_CONTAINER)
	
stop:
	@sudo docker stop $(APP_CONTAINER)
	@echo '$(APP_CONTAINER) has been stoped'

logs:
	@sudo docker logs -f $(APP_CONTAINER)

into:
	@sudo docker exec -it $(APP_CONTAINER) /bin/bash

rm:
	@sudo docker rm $(APP_CONTAINER)
	@echo 'Container $(APP_CONTAINER) removed'

rmi:
	@sudo docker rmi $(APP_IMG)
	@echo 'Image $(APP_IMG) removed'
