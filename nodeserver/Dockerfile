# ---------------------------------------------------------------- #
#  GOOD CONFIG avec npm run start pour prod : 
# ---------------------------------------------------------------- #

FROM node:14.16.1

# Create app directory
WORKDIR /usr/src/app

# Install app dependencies
# A wildcard is used to ensure both package.json AND package-lock.json are copied
# where available (npm@5+)
COPY package*.json ./

# RUN npm install
# If you are building your code for production
# RUN npm ci --only=production

# Bundle app source
COPY . .

# EXPOSE 80
# CMD [ "node", "server.js" ]

# copy the app, note .dockerignore
# COPY . /usr/src/app/
# RUN npm install
# RUN npm run build

# EXPOSE 3000

ENV NUXT_HOST=0.0.0.0
ENV NUXT_PORT=3000


EXPOSE 8085
CMD [ "npm" , "start" ]


# ---------------------------------------------------------------- #
#  / END GOOD CONFIG avec npm run start pour prod : 
# ---------------------------------------------------------------- #
