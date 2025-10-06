export class AppError extends Error {
    constructor(message: string) {
        super(message);
        this.name = "AppError";
    }
}

export class ValidationError extends AppError {
    constructor(message: string) {
        super(message);
        this.name = "ValidationError";
    }
}

export class NotFoundError extends AppError {
    constructor(message: string) {
        super(message);
        this.name = "NotFoundError";
    }
}

export class DatabaseError extends AppError {
    constructor(message: string) {
        super(message);
        this.name = "DatabaseError";
    }
}

export class OcrError extends AppError {
    constructor(message: string) {
        super(message);
        this.name = "OcrError";
    }
}

export class FileUploadError extends AppError {
    constructor(message: string) {
        super(message);
        this.name = "FileUploadError";
    }
}

export class ApiError extends AppError {
    constructor(message: string) {
        super(message);
        this.name = "ApiError";
    }
}

export class ParsingError extends AppError {
    constructor(message: string) {
        super(message);
        this.name = "ParsingError";
    }
}