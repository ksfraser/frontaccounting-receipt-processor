# SupplierService Documentation

## Overview
The `SupplierService` class is responsible for managing suppliers in the application. It provides methods to add, update, retrieve, and remove suppliers, as well as retrieve all suppliers.

## Class Details

### Namespace
`App\Suppliers`

### Dependencies
- `App\Models\Supplier`
- `InvalidArgumentException`

### Properties
- `private array $suppliers`: An associative array to store suppliers, keyed by their IDs.

### Methods

#### `__construct()`
Initializes the `suppliers` array.

#### `addSupplier(Supplier $supplier): void`
Adds a new supplier to the collection.
- Throws `InvalidArgumentException` if the supplier already exists.

#### `updateSupplier(Supplier $supplier): void`
Updates an existing supplier in the collection.
- Throws `InvalidArgumentException` if the supplier does not exist.

#### `getSupplier(string $id): ?Supplier`
Retrieves a supplier by its ID.
- Returns `null` if the supplier does not exist.

#### `getAllSuppliers(): array`
Retrieves all suppliers as an array.

#### `removeSupplier(string $id): void`
Removes a supplier by its ID.
- Throws `InvalidArgumentException` if the supplier does not exist.

## Usage Examples

### Adding a Supplier
```php
use App\Suppliers\SupplierService;
use App\Models\Supplier;

$supplierService = new SupplierService();
$supplier = new Supplier('1', 'Supplier A');
$supplierService->addSupplier($supplier);
```

### Updating a Supplier
```php
$updatedSupplier = new Supplier('1', 'Updated Supplier A');
$supplierService->updateSupplier($updatedSupplier);
```

### Retrieving a Supplier
```php
$supplier = $supplierService->getSupplier('1');
if ($supplier !== null) {
    echo $supplier->getName();
}
```

### Removing a Supplier
```php
$supplierService->removeSupplier('1');
```

## UML Diagram
Refer to the [UML diagram](uml/SupplierService.puml) for a visual representation of the `SupplierService` class and its relationship with the `Supplier` model.
