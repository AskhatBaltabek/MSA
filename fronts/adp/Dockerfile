FROM node:10

WORKDIR ./app/adp_front

COPY package*.json ./

RUN npm install

EXPOSE 8080

CMD ["npm", "run", "serve"]