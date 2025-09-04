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