FROM node:15.4 as build
WORKDIR /app
COPY package*.json .
RUN npm install
RUN vue add vutify
RUN npm install axios
COPY . .
RUN npm run build

FROM nginx:1.19