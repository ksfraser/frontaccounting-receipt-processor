import { config as dotenvConfig } from 'dotenv';
import * as fs from 'fs';
import * as path from 'path';

dotenvConfig();

const loadConfig = (env: string) => {
    const configPath = path.join(__dirname, `${env}.json`);
    if (fs.existsSync(configPath)) {
        return JSON.parse(fs.readFileSync(configPath, 'utf-8'));
    }
    throw new Error(`Configuration file for environment "${env}" not found.`);
};

const environment = process.env.NODE_ENV || 'development';
export const config = loadConfig(environment);

export type AppConfig = typeof config;