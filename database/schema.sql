-- Temel kullanıcı ve yetki tabloları
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    username VARCHAR(60) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'sadece_goruntule',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE,
    description VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    module VARCHAR(100) NOT NULL,
    can_view TINYINT(1) DEFAULT 0,
    can_create TINYINT(1) DEFAULT 0,
    can_update TINYINT(1) DEFAULT 0,
    can_delete TINYINT(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS role_permissions (
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sistem ayarları
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(150),
    tax_office VARCHAR(120),
    tax_number VARCHAR(60),
    address VARCHAR(255),
    phone VARCHAR(60),
    email VARCHAR(120),
    logo VARCHAR(255),
    default_currency VARCHAR(3) DEFAULT 'TRY',
    date_format VARCHAR(20) DEFAULT 'd.m.Y',
    timezone VARCHAR(80) DEFAULT 'Europe/Istanbul',
    default_payment_term INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS currencies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(3) UNIQUE,
    rate DECIMAL(14,6) DEFAULT 1,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Cari kartlar
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE,
    name VARCHAR(150) NOT NULL,
    tax_office VARCHAR(120),
    tax_number VARCHAR(60),
    address VARCHAR(255),
    phone VARCHAR(60),
    email VARCHAR(120),
    contact_person VARCHAR(120),
    type VARCHAR(20) DEFAULT 'Müşteri',
    payment_terms INT DEFAULT 0,
    currency VARCHAR(3) DEFAULT 'TRY',
    credit_limit DECIMAL(14,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Ürün kartı
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(60) UNIQUE,
    name VARCHAR(150) NOT NULL,
    barcode VARCHAR(120),
    unit VARCHAR(20),
    vat_rate DECIMAL(5,2) DEFAULT 18,
    purchase_price DECIMAL(14,2) DEFAULT 0,
    sale_price DECIMAL(14,2) DEFAULT 0,
    currency VARCHAR(3) DEFAULT 'TRY',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS warehouses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE,
    name VARCHAR(120),
    address VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Satış belgeleri
CREATE TABLE IF NOT EXISTS sales_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doc_no VARCHAR(60) NOT NULL,
    doc_type VARCHAR(20) NOT NULL,
    customer_id INT NOT NULL,
    doc_date DATE NOT NULL,
    currency VARCHAR(3) DEFAULT 'TRY',
    status VARCHAR(30) DEFAULT 'Taslak',
    total DECIMAL(14,2) DEFAULT 0,
    notes VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS sales_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    document_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity DECIMAL(14,3) NOT NULL,
    price DECIMAL(14,2) NOT NULL,
    vat_rate DECIMAL(5,2) DEFAULT 18,
    FOREIGN KEY (document_id) REFERENCES sales_documents(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Stok hareketleri
CREATE TABLE IF NOT EXISTS stock_movements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    quantity DECIMAL(14,3) NOT NULL,
    movement_type VARCHAR(30),
    source_document INT NULL,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Basit finans tabloları
CREATE TABLE IF NOT EXISTS cash_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NULL,
    direction VARCHAR(10) NOT NULL,
    amount DECIMAL(14,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'TRY',
    trans_date DATE NOT NULL,
    description VARCHAR(255),
    FOREIGN KEY (customer_id) REFERENCES customers(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS bank_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bank_name VARCHAR(120),
    iban VARCHAR(34),
    currency VARCHAR(3) DEFAULT 'TRY'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS bank_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bank_account_id INT NOT NULL,
    direction VARCHAR(10) NOT NULL,
    amount DECIMAL(14,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'TRY',
    trans_date DATE NOT NULL,
    description VARCHAR(255),
    FOREIGN KEY (bank_account_id) REFERENCES bank_accounts(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Üretim
CREATE TABLE IF NOT EXISTS bill_of_materials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    component_id INT NOT NULL,
    quantity DECIMAL(14,3) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (component_id) REFERENCES products(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS production_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_no VARCHAR(60),
    product_id INT NOT NULL,
    bom_id INT NULL,
    quantity DECIMAL(14,3) NOT NULL,
    start_date DATE,
    end_date DATE,
    status VARCHAR(30) DEFAULT 'Planlandı',
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (bom_id) REFERENCES bill_of_materials(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Proje ve görev yönetimi
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150),
    customer_id INT NULL,
    start_date DATE,
    end_date DATE,
    status VARCHAR(30) DEFAULT 'Aktif',
    FOREIGN KEY (customer_id) REFERENCES customers(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    description VARCHAR(255),
    assignee_id INT NULL,
    start_date DATE,
    end_date DATE,
    status VARCHAR(30) DEFAULT 'Yapılacak',
    FOREIGN KEY (project_id) REFERENCES projects(id),
    FOREIGN KEY (assignee_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
