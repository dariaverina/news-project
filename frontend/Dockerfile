FROM node:20

WORKDIR /app

COPY . .

RUN yarn install

CMD ["yarn", "dev", "--host", "0.0.0.0"]