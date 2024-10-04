# Use an official Node runtime as the base image
FROM node:16

# Set the working directory in the container
WORKDIR /app

# Copy package.json and package-lock.json to the working directory
COPY package*.json ./

# Install the application dependencies
RUN npm install

# Copy the rest of the application code to the working directory
COPY . .

# Expose port 5173 (Vite's default port)
EXPOSE 5173

# Run the application in development mode
CMD ["npm", "run", "dev"]