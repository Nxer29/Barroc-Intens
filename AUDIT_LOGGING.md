# Audit Logging Systeem

Dit document beschrijft hoe het auditlogging systeem in de Barroc Intens applicatie werkt.

## Overzicht

Het auditlogging systeem traceert alle gebruikersacties in het systeem. Dit biedt volledige traceerbaarheid van wijzigingen en het kan gebruikt worden voor:

- Beveiligings- en compliancetracking
- Debugging en probleemoplossing
- Gebruikersverantwoordelijkhebrieven
- Gegevensintegriteit verificatie

## Database Schema

De `audit_logs` tabel heeft de volgende structuur:

| Kolom     | Type        | Beschrijving                                                  |
| --------- | ----------- | ------------------------------------------------------------- |
| id        | ID          | Unieke identifier                                             |
| user_id   | Foreign Key | Verwijzing naar de gebruiker die de actie uitvoerde           |
| action    | Text        | De actie die werd uitgevoerd (created, updated, deleted, etc) |
| entity    | String      | Het type entiteit waarop de actie werd uitgevoerd             |
| entity_id | Big Integer | De ID van de entiteit                                         |
| timestamp | Timestamp   | Wanneer de actie plaatsvond                                   |

## Features

### 1. Audit Log Dashboard

- **URL**: `/auditlogs` (alleen voor Admin rollen)
- **Features**:
    - Tabel met alle auditlog entries
    - Toon: timestamp, gebruiker, actie, entiteit, entity_id
    - Kleurcoding voor acties (groen=created, blauw=updated, rood=deleted)

### 2. Zoeken en Filteren

- **Zoeken**: Zoek op actie, entiteit, ID, gebruikersnaam of email
- **Filter op Actie**: Selecteer een specifieke actie uit de dropdown
- **Filter op Entiteit**: Selecteer een specifiek entity type
- **Filter op Gebruiker**: Selecteer een specifieke gebruiker
- **Filter op Datum**: Selecteer een datumbereik (Van / Tot)
- **Wissen knop**: Reset alle filters en zoektermen

### 3. Paginatie

- Resultaten worden pagina voor pagina getoond (50 records per pagina)
- Navigeer met de paginatieknoppen onderaan
- Totaalaantal records wordt weergegeven

## Hoe Audit Logging te Implementeren

### Methode 1: AuditService Direct Gebruiken

Als je een actie wilt loggen in een controller:

```php
use App\Services\AuditService;

// In een controller methode:
public function store(Request $request)
{
    $product = Product::create($request->validated());

    // Log the creation
    AuditService::logCreated('Product', $product->id);

    return redirect()->route('products.show', $product);
}

public function update(Request $request, Product $product)
{
    $product->update($request->validated());

    // Log the update
    AuditService::logUpdated('Product', $product->id);

    return redirect()->route('products.show', $product);
}

public function destroy(Product $product)
{
    $productId = $product->id;
    $product->delete();

    // Log the deletion
    AuditService::logDeleted('Product', $productId);

    return redirect()->route('products.index');
}
```

### Methode 2: Auditable Trait (Automatisch)

Voor automatische logging op create/update/delete, voeg de `Auditable` trait toe aan je model:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Product extends Model
{
    use Auditable;

    // ... rest van je model

    // Optioneel: Pas de entity naam aan als je wilt
    protected string $auditableEntity = 'Product';
}
```

Nu worden alle create, update, en delete acties automatisch gelogd!

## AuditService API

```php
// Log een generieke actie
AuditService::log($action, $entity, $entityId, $userId = null);

// Log een creatie
AuditService::logCreated($entity, $entityId, $userId = null);

// Log een update
AuditService::logUpdated($entity, $entityId, $userId = null);

// Log een verwijdering
AuditService::logDeleted($entity, $entityId, $userId = null);
```

Alle methodes accepteren optioneel een `$userId`. Als deze niet wordt opgegeven, wordt de huidige ingelogde gebruiker gebruikt.

## Voorbeelden

### Voorbeeld 1: Handmatige logging in een controller

```php
use App\Services\AuditService;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        $customer = Customer::create($request->validated());
        AuditService::logCreated('Customer', $customer->id);
        return redirect()->route('customers.show', $customer);
    }
}
```

### Voorbeeld 2: Automatische logging met Trait

```php
use App\Traits\Auditable;

class Invoice extends Model
{
    use Auditable;

    // Alle create, update, delete acties worden nu automatisch gelogd
}
```

### Voorbeeld 3: Aangepast entity type met trait

```php
class WorkOrder extends Model
{
    use Auditable;

    // Dit overschrijft de standaard entity naam (WorkOrder -> CustomName)
    protected string $auditableEntity = 'WorkOrder';
}
```

## Access Control

De audit logs pagina is beveiligd en kan **alleen** door administrators (met de "Admin" rol) worden benaderd.

```php
Route::group(['middleware' => ['role:Admin']], function () {
    Route::get('/auditlogs', [AuditLogController::class, 'index'])->name('auditlogs.index');
});
```

## Best Practices

1. **Zorg altijd voor context**: Log niet alleen automatisch met traits, maar voeg waar relevant extra context toe
2. **Naamgeving**: Gebruik consistente entity namen (dezelfde als je model klassennaam)
3. **Acties**: Gebruik standaard acties: `created`, `updated`, `deleted`, en eventueel custom zoals `published`, `approved`, etc.
4. **Controle**: Check regelmaal de audit logs om verdachte activiteiten op te sporen

## Troubleshooting

### Audit Logs verschijnen niet

- Controleer of je ingelogde gebruiker ID heeft (niet null)
- Verificatie dat de `AuditService::log()` methode correct wordt aangeroepen
- Check je database connectie

### Filter werkt niet

- Zorg dat je exact matchende waarden gebruikt
- Probeer eerst op één filter tegelijk

### Performance

- Bij zeer veel audit logs kan paginatie traag worden
- Overweeg om oude logs te archiveren
