FROM wordpress:latest

ENV DB_HOST=vpoids-prod-db.mysql.database.azure.com
ENV DB_USER=vpoids_db_admin
ENV DB_PASSWORD=poids_db1
ENV DB_NAME=vpoids_db

# Copy any custom configuration files (optional)
COPY wp-config.php /var/www/html/wp-config.php

# Install additional PHP extensions if needed
RUN apt-get update && \
    apt-get install -y \
    # List any required extensions here, e.g., \
    # zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Set permissions if necessary
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 for HTTP
EXPOSE 80

# Define the entry point
CMD ["apache2-foreground"]
