# Feature: Werkbezoek Detailweergave (Work Visit Detail View)

**Status**: ✅ Complete  
**Date Implemented**: February 26, 2026  
**User Story**: s2-Werkbezoek detailweergave

## Overview

This feature provides technicians with a quick and comprehensive view of scheduled work visits, displaying all critical information needed to prepare for and execute the visit efficiently.

## User Story

> **As a technician**, I want to **quickly see details of a planned visit**, so that I can **prepare properly and understand what needs to be done**.

### Acceptance Criteria

✅ Modal/page displays:

- Problem description (Probleemomschrijving)
- Required materials (Benodigde spullen)
- Customer information (Klantinfo)
- Contract reference (Contractreferentie)

## Features Implemented

### 1. Enhanced API Endpoint: `/calendar/appointment/{appointment}`

**File**: `app/Http/Controllers/CalendarController.php`

The `appointmentDetails()` method returns comprehensive JSON data including:

- **Appointment Details**: ID, scheduled date/time, status, type, notes
- **Customer Information**: Company name, contact person, email, phone
- **Customer Address**: Street, postal code, city, country
- **Problem Description**: Issue from MaintenanceRequest with urgency and priority
- **Contract Information**: Contract name, status, dates, and products
- **Materials Used**: From WorkOrder (if visit is completed)

**Response Structure**:

```json
{
    "id": 1,
    "scheduled_at": "2026-02-26T14:30:00+00:00",
    "status": "planned",
    "customer": {
        "id": 1,
        "name": "Company Name",
        "contact_name": "John Doe",
        "contact_email": "john@example.com",
        "contact_phone": "+31 6 12345678"
    },
    "address": {
        "street": "Main Street 123",
        "postal_code": "3000 AA",
        "city": "Rotterdam",
        "country": "Netherlands"
    },
    "maintenance_request": {
        "id": 1,
        "request_number": "MR-001",
        "issue_description": "Device not responding...",
        "urgency": "high",
        "priority": "critical",
        "product": { "id": 1, "name": "Product Name" }
    },
    "contract": {
        "id": 1,
        "name": "Maintenance Contract 2024",
        "status": "active",
        "start_date": "2024-01-01",
        "end_date": "2024-12-31",
        "products": [
            {
                "id": 1,
                "name": "Part A",
                "quantity": 2,
                "unit_price": 49.99
            }
        ]
    },
    "materials_used": [
        {
            "id": 1,
            "product_id": 1,
            "product_name": "Part A",
            "quantity": 1,
            "unit_price": 49.99
        }
    ]
}
```

### 2. Calendar View Modals (Quick Access)

**Files**:

- `resources/views/calendar/day.blade.php`
- `resources/views/calendar/monteur/day.blade.php`
- `resources/views/calendar/monteur/week.blade.php`

#### Modal Sections:

1. **Time & Status Badge**
    - Date and time of the scheduled visit
    - Color-coded status (Planned, Completed, Cancelled)

2. **Visit Type**
    - Display the type of work visit (e.g., Maintenance, Installation)

3. **Customer Information** (bg-slate-700/40)
    - Company name (prominent)
    - Contact person name
    - Email address (clickable)
    - Phone number

4. **Customer Address** (conditional display)
    - Street address
    - Postal code and city
    - Country

5. **Problem/Issue Description** (bg-slate-700/40)
    - Full text of the maintenance request issue
    - Falls back to appointment notes if no maintenance request

6. **Contract Information** (bg-slate-700/40)
    - Contract name and reference ID
    - Status and date range
    - **"Producten onder contract"** - Products required/available according to contract
    - Product names with quantities (e.g., "Part A (2x)")

7. **Materials Used** (bg-green-900/20, hidden by default)
    - Appears only if WorkOrder exists with used materials
    - Shows what was actually used during the visit
    - Helps technician review what was consumed

8. **Notes**
    - General notes and comments about the visit

9. **Action Buttons**
    - Close button
    - Edit button (links to appointments.edit)

**JavaScript Functions**:

- `openAppointmentModal(appointmentId)` - Opens modal and fetches data
- `populateModal(data)` - Populates modal fields with JSON data
- `closeAppointmentModal()` - Closes modal
- `formatDate(dateString)` - Format dates to Dutch locale
- `ucfirst(str)` - Capitalize first letter
- `escapeHtml(str)` - HTML escape for security (in day.blade.php)

### 3. Detail Page View (Full Information)

**File**: `resources/views/appointments/show.blade.php`

Completely redesigned to show comprehensive information:

#### Layout: 3-Column Grid

**Column 1 (Left)**: Sidebar

- General Information Card: Type, Date/Time, Technician
- Status Badge: Visual status indicator

**Columns 2-3 (Main Content)**:

- **👤 Klantinformatie**: Company, contact, email, phone, location
- **⚠️ Probleemomschrijving**: Issue description with storingsreferentie
- **📋 Contractgegevens & Benodigde spullen**: Contract info and products grid

#### Display Logic:

- Shows delivery address if available, otherwise invoice address
- Problem section only displays if MaintenanceRequest exists
- Contract section only displays if active contract exists
- Products displayed in responsive grid with quantity and unit price
- Color-coded status badges and icons for visual clarity

## Technical Implementation

### Backend Changes

**CalendarController.php**:

```php
// Line 92-103: Load WorkOrder and materials
$workOrder = \App\Models\WorkOrder::where('appointment_id', $appointment->id)
    ->with(['materials.product'])
    ->first();

// Lines 165-173: Add to JSON response
'materials_used' => $workOrder ? $workOrder->materials->map(fn($m) => [...]) : null,
'work_order' => $workOrder ? [
    'id' => $workOrder->id,
    'notes' => $workOrder->notes,
    'performed_by' => \App\Models\User::find($workOrder->performed_by)?->name,
] : null,
```

### Frontend Changes

**Modal HTML**:

- New section: `id="materialsUsedSection"` for displaying used materials
- Hidden by default with `hidden` class
- Green styling (`border-green-900/50`, `bg-green-900/20`) to differentiate from required materials

**JavaScript Updates**:

- Materials handling in `populateModal()` function
- Conditional display based on `data.materials_used` array
- Dynamic list generation with product names and quantities

**Page Template**:

- Restructured grid layout for better information hierarchy
- Added emoji icons for visual section identification
- Improved responsive design with proper spacing
- Enhanced color scheme with status badges

## User Flow

### For Quick Access (Calendar Modal)

1. Technician opens Calendar view (Day or Week view)
2. Clicks on an appointment tile
3. Modal opens with loading animation
4. API fetches appointment details including maintenance request and contract
5. Modal populates with:
    - Time & Status
    - Customer details
    - Problem description
    - Required materials (contract products)
    - Previous materials used (if applicable)
6. Technician can read all necessary info or click "Bewerk" to edit

### For Full Details (Detail Page)

1. Technician navigates to Appointments
2. Clicks on specific appointment
3. Full detail page loads with comprehensive information
4. Can review all information or click "Bewerken" to edit

## Data Relationships

```
Appointment
├── Customer
│   ├── Contracts
│   │   └── Products (with pivot: quantity, unit_price)
│   ├── Invoice Address
│   └── Delivery Address
├── MaintenanceRequest
│   ├── Issue Description
│   └── Product (what's broken)
├── WorkOrder
│   └── MaterialsUsed
│       └── Product (what was used)
└── Type (AppointmentType)
```

## Testing Checklist

- [x] API endpoint returns correct data structure
- [x] Modal displays all sections correctly
- [x] Conditional sections hide/show appropriately
- [x] Mobile responsive design works
- [x] JavaScript escaping prevents XSS attacks
- [x] Detail page layout is responsive and readable
- [x] Status badges display with correct colors
- [x] Links to edit page work correctly
- [x] Quantities display for products and materials
- [x] Fallback data (N/A) displays when data missing

## Browser Support

- Desktop browsers (Chrome, Firefox, Safari, Edge)
- Mobile browsers (iOS Safari, Chrome Mobile)
- Responsive breakpoints: sm (640px), md (768px), lg (1024px)

## Styling

**Theme Colors**:

- Primary: Slate 800/900
- Accent: Yellow 400
- Success: Green 900/20
- Warning: Orange 900/40
- Border: Slate 700

**Typography**:

- Headers: Bold, large sizes (xl, 2xl, 3xl, 4xl)
- Body: Gray 200, readable contrast
- Labels: Gray 400, smaller size (xs, sm)

## Accessibility Features

- Semantic HTML with proper heading hierarchy
- Color used with text labels (not only for meaning)
- Sufficient contrast ratios for readability
- Keyboard navigable modals
- Focus management in modal
- Proper ARIA labels (via Blade components)

## Future Enhancements

- [ ] Export visit details to PDF
- [ ] Share visit info via email/SMS
- [ ] Add photo upload for before/after
- [ ] Integration with parts inventory system
- [ ] Time tracking for the visit
- [ ] Customer signature capture
- [ ] Multi-language support

## Files Modified

1. `app/Http/Controllers/CalendarController.php` - Enhanced appointmentDetails method
2. `resources/views/calendar/day.blade.php` - Added materials section & updated modal
3. `resources/views/calendar/monteur/day.blade.php` - Added materials section & updated modal
4. `resources/views/calendar/monteur/week.blade.php` - Added materials section & updated modal
5. `resources/views/appointments/show.blade.php` - Completely redesigned detail page

## Documentation

- This file: Feature overview and implementation details
- Code comments in modified files
- API response structure documented in CalendarController

---

**Created**: February 26, 2026  
**Feature ID**: s2-Werkbezoek detailweergave  
**Status**: ✅ Ready for Testing & Deployment
