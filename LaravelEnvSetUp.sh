#!/bin/bash

databaseList=('sqlite' 'mysql' 'mariadb' 'postgres')
environmentList=('development' 'production')
PS3="Select a number: "
envFilePath=".env"

settingUpEnvironmentVariables () {
    key=$1
    value=$2
    if grep -q "^$key=" "$envFilePath"; then
        sed -i "s|^$key=.*|$key=$value|" "$envFilePath"
    else
        echo "$key=$value" >> "$envFilePath"
    fi
}

echo "=== Laravel .env Setup Script ==="

if [ ! -f "$envFilePath" ]; then
    if [ -f "${envFilePath}.example" ]; then
        cp "${envFilePath}.example" "$envFilePath"
        echo ".env file was not found. Creating new .env"
    else
        echo "Error: Neither $envFilePath nor ${envFilePath}.example exists."
        exit 1
    fi
fi

# Ask for APP_NAME
read -p "Enter application name (APP_NAME): " app_name
settingUpEnvironmentVariables  "APP_NAME" "$app_name"
settingUpEnvironmentVariables  "VITE_APP_NAME" "\"$app_name\""

# Ask for APP_URL
read -p "Enter application URL (APP_URL) [default: http://localhost]: " app_url
app_url=${app_url:-http://localhost}
settingUpEnvironmentVariables "APP_URL" "$app_url"

# Ask for APP_ENV
select environment in ${environmentList[@]}; do
    case $environment in
        production)
            settingUpEnvironmentVariables  "APP_ENV" "production"
            break
            ;;
        development)
            settingUpEnvironmentVariables  "APP_ENV" "development"
            break
            ;;
        *)
            echo "Invalid option, try again."
            ;;
    esac
done

# Ask for APP_DEBUG
while true; do
    read -p "Enable debug? (y/N): " appDebugOption
    appDebugOption=$(echo "$appDebugOption" | tr '[:upper:]' '[:lower:]')

    if [[ "$appDebugOption" == "yes" || "$appDebugOption" == "ye" || "$appDebugOption" == "y" ]]; then
        app_debug="true"
        break
    elif [[ "$appDebugOption" == "no" || "$appDebugOption" == "n" || "$appDebugOption" == "" ]]; then
        app_debug="false"
        break
    else
        echo "Invalid choice."
    fi
done

settingUpEnvironmentVariables  "APP_DEBUG" "$app_debug"

# Database selection
echo "Select database type:"
select databaseType in ${databaseList[@]}; do
    case $databaseType in
        sqlite)
            settingUpEnvironmentVariables  "DB_CONNECTION" "sqlite"
            # Comment out other DB lines
            sed -i 's/^DB_HOST/# DB_HOST/' "$envFilePath"
            sed -i 's/^DB_PORT/# DB_PORT/' "$envFilePath"
            sed -i 's/^DB_DATABASE/# DB_DATABASE/' "$envFilePath"
            sed -i 's/^DB_USERNAME/# DB_USERNAME/' "$envFilePath"
            sed -i 's/^DB_PASSWORD/# DB_PASSWORD/' "$envFilePath"
            break
            ;;
        mysql|mariadb|postgres)
            settingUpEnvironmentVariables  "DB_CONNECTION" "$databaseType"
            
            # Ask for DB credentials
            read -p "Database host (default: 127.0.0.1): " databaseHost
            databaseHost=${databaseHost:-127.0.0.1}
            read -p "Database port (default: 3306 for mysql/mariadb, 5432 for postgres): " databasePort
            if [[ -z "$databasePort" ]]; then
                if [[ "$databaseType" == "postgres" ]]; then
                    databasePort=5432
                else
                    databasePort=3306
                fi
            fi
            read -p "Database name: " databaseName
            read -p "Database username: " databaseUser
            read -sp "Database password: " databasePassword
            echo

            # Uncomment and set DB lines
            sed -i 's/^# DB_HOST/DB_HOST/' "$envFilePath"
            sed -i 's/^# DB_PORT/DB_PORT/' "$envFilePath"
            sed -i 's/^# DB_DATABASE/DB_DATABASE/' "$envFilePath"
            sed -i 's/^# DB_USERNAME/DB_USERNAME/' "$envFilePath"
            sed -i 's/^# DB_PASSWORD/DB_PASSWORD/' "$envFilePath"

            settingUpEnvironmentVariables "DB_HOST" "$databaseHost"
            settingUpEnvironmentVariables "DB_PORT" "$databasePort"
            settingUpEnvironmentVariables "DB_DATABASE" "$databaseName"
            settingUpEnvironmentVariables "DB_USERNAME" "$databaseUser"
            settingUpEnvironmentVariables "DB_PASSWORD" "$databasePassword"
            break
            ;;
        *)
            echo "Invalid option, try again."
            ;;
    esac
done

echo ".env file updated successfully."
