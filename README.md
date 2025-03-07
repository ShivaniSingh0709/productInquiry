# ProductInquiry Magento 2 Module

## Module Overview
The **ProductInquiry** module enables customers to submit product-related inquiries directly from the product detail page. The store admin receives an email notification and can manage inquiries from the Magento admin panel. Additionally, the admin can respond to customer inquiries directly from the backend.

## Installation
1. Place the module inside `app/code/Vendor/ProductInquiry/`
2. Run the following Magento CLI commands:
   ```sh
   php bin/magento module:enable Vendor_ProductInquiry
   php bin/magento setup:upgrade
   php bin/magento setup:di:compile
   php bin/magento cache:flush
   ```

## Module Directory Structure
```
Vendor/
└── ProductInquiry/
    ├── Block/
    │   ├── ProductInquiry.php
    ├── Controller/
    │   ├── Adminhtml/Inquiry/
    │   │   ├── Index.php
    │   │   ├── SendResponse.php
    │   ├── Index/
    │   │   ├── Index.php
    ├── etc/
    │   ├── adminhtml/
    │   │   ├── di.xml
    │   │   ├── menu.xml
    │   │   ├── routes.xml
    │   ├── frontend/
    │   │   ├── routes.xml
    │   ├── db_schema.xml
    │   ├── db_schema_whitelist.json
    │   ├── email_templates.xml
    │   ├── module.xml
    ├── Helper/
    │   ├── EmailHelper.php
    ├── Model/
    │   ├── Inquiry.php
    │   ├── ResourceModel/
    │   │   ├── Inquiry.php
    ├── Ui/
    │   ├── Component/Listing/Columns/
    │   │   ├── Sendmail.php
    ├── view/
    │   ├── adminhtml/
    │   │   ├── email/
    │   │   │   ├── product_inquiry_email_template.html
    │   │   ├── layout/
    │   │   │   ├── productinquiry_inquiry_index.xml
    │   │   ├── ui_component/
    │   │   │   ├── productinquiry_inquiry_listing.xml
    │   │   ├── base/web/
    │   │   │   ├── js/grid/columns/senderesponse.js
    │   │   ├── templates/grid/cells/customer/
    │   │   │   ├── sendmail.html
    │   ├── frontend/
    │   │   ├── email/
    │   │   │   ├── product_inquiry_email_template.html
    │   │   ├── layout/
    │   │   │   ├── catalog_product_view.xml
    │   │   ├── templates/
    │   │   │   ├── inquiry.phtml
    ├── registration.php
```

## Module Components and Their Roles

### A. Block
- `ProductInquiry.php`: Provides logic for rendering the inquiry form on the frontend.

### B. Controller
#### Frontend:
- `Index/Index.php`: Displays the inquiry form on the product detail page.
#### Adminhtml:
- `Adminhtml/Inquiry/Index.php`: Displays the list of product inquiries in the admin panel.
- `Adminhtml/Inquiry/SendResponse.php`: Handles the admin’s response to customer inquiries.

### C. etc (Configuration Files)
- `module.xml`: Declares the module.
- `routes.xml`:
  - **Adminhtml**: Registers the admin routes.
  - **Frontend**: Registers the frontend routes.
- `menu.xml`: Adds the module's menu item to the Magento admin panel.
- `di.xml`: Configures dependencies and class preferences.
- `db_schema.xml`: Defines the database schema.
- `db_schema_whitelist.json`: Ensures the schema changes are applied correctly.
- `email_templates.xml`: Registers the email templates.

### D. Helper
- `EmailHelper.php`: Handles email notifications for inquiries and admin responses.

### E. Model
- `Inquiry.php`: Defines the Inquiry model.
- `ResourceModel/Inquiry.php`: Handles database interactions.

### F. UI Component
- `Ui/Component/Listing/Columns/Sendmail.php`: Adds a “Send Mail” button to the admin grid.

### G. View
#### Adminhtml:
- `email/product_inquiry_email_template.html`: Email template for admin notifications.
- `layout/productinquiry_inquiry_index.xml`: Defines the layout for the admin inquiry listing page.
- `ui_component/productinquiry_inquiry_listing.xml`: Configures the admin grid.
- `js/grid/columns/senderesponse.js`: JavaScript for handling the admin reply button.
- `templates/grid/cells/customer/sendmail.html`: Admin UI for sending replies.
#### Frontend:
- `layout/catalog_product_view.xml`: Adds the inquiry form to the product detail page.
- `email/product_inquiry_email_template.html`: Email template for customer inquiries.
- `templates/inquiry.phtml`: Renders the inquiry form on the frontend.

### H. Registration
- `registration.php`: Registers the module with Magento.

## Key Features
- **Frontend Inquiry Form**: Allows customers to submit product inquiries.
- **Admin Inquiry Management**: Admins can view, manage, and respond to inquiries.
- **Email Notifications**: Notifies admins and customers about inquiries and responses.
- **Database Storage**: Stores inquiry details in the database.
- **Admin Grid**: Displays a list of inquiries in the Magento admin panel.
- **Inline Admin Replies**: Admins can respond to inquiries directly from the grid.

## License
This module is open-source and can be modified as per your needs.

## Support
For any issues or customizations, please contact the developer or raise an issue in the repository.

