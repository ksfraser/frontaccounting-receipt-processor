# INSTALL.md

## Front Accounting Receipt Processor Installation Guide

This guide covers installation and setup for both Docker and manual Fedora webserver environments. It also explains upload options and how parsed PDF/JPG files are attached to supplier invoices.

---

## Prerequisites
- Node.js (LTS recommended)
- npm (comes with Node.js)
- Git (optional, for cloning)
- [Fedora only] Python3, build tools, and development libraries for native modules

---

## 1. Manual Installation (Fedora Webserver)

### 1.1. Install Node.js and npm
```bash
sudo dnf install nodejs npm git
```

### 1.2. Clone the repository
```bash
git clone https://github.com/yourusername/frontaccounting-receipt-processor.git
cd frontaccounting-receipt-processor
```

### 1.3. Install dependencies
```bash
npm install
```

### 1.4. Configure environment
Edit `config/development.json`:
```json
{
  "port": 3000,
  "faBaseUrl": "http://localhost:8080/api",
  "faApiKey": "changeme"
}
```

Optionally, create a `.env` file for environment variables.

### 1.5. Run the server
```bash
npm start
```

### 1.6. Run tests
```bash
npm test
```

---

## 2. Docker Installation

### 2.1. Build and run with Docker Compose
```bash
docker-compose up --build
```

This will build the image and start the server as defined in `docker-compose.yml`.

### 2.2. Standalone Docker
```bash
docker build -t fa-receipt-processor .
docker run -p 3000:3000 fa-receipt-processor
```

---

## 3. Upload Options

### 3.1. API Upload
- Use the `/upload` endpoint to POST receipt files (PDF/JPG):

Example using `curl`:
```bash
curl -F "receipt=@/path/to/receipt.pdf" http://localhost:3000/upload
```

### 3.2. Directory Watch
- Place files in the `receipts/` directory. The app will automatically process new files.

---

## 4. Supplier Invoice Creation & File Attachment

When a receipt is uploaded or detected, the system:
- Parses the PDF/JPG using OCR
- Extracts supplier, items, and total
- Creates a supplier invoice in Front Accounting
- **Attaches the original PDF/JPG to the invoice record** (via API, if supported)

**API Example:**
- The `/upload` endpoint will process the file and send invoice data to Front Accounting, including a reference or upload of the original file.
- If Front Accounting supports file attachments via API, the file will be uploaded and linked to the invoice.
- If not, the file path or URL will be included in the invoice payload for manual review.

---

## 5. Configuration Notes
- Edit `config/development.json` for API keys, ports, and FA endpoint.
- For production, use `config/production.json` and set `NODE_ENV=production`.

---

## 6. Troubleshooting
- Ensure all dependencies are installed (`npm install`).
- For native modules (e.g., Tesseract), install build tools:
  ```bash
  sudo dnf groupinstall "Development Tools"
  sudo dnf install python3 python3-devel
  ```
- Check logs in `application.log` for errors.

---

## 7. API Endpoints Summary
- `POST /upload` — Upload and process receipt
- `POST /fa/supplier` — Sync supplier
- `POST /fa/item` — Sync item
- `GET /fa/invoices` — List invoices
- `GET /fa/items` — List items
- `GET /fa/suppliers` — List suppliers
- `GET /fa/item/:id/prices` — Get item prices

---

## 8. Customization
- To change upload directory, edit the path in `src/ingestion/uploadHandler.ts` and `fileWatcher.ts`.
- To add more file types, update the file extension checks in those files.

---

## 9. Support
For issues, open a GitHub issue or contact the maintainer.
