FROM node:10-alpine

RUN apk update && apk upgrade

RUN npm install -g browser-sync

ENTRYPOINT ["browser-sync", "start", "--proxy", "server", "--files", "themes/**/*.php", "--no-open", "false"]

WORKDIR /app
