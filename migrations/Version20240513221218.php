<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513221218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE api_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) DEFAULT NULL, username VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, api_key VARCHAR(255) DEFAULT NULL, expiry_date DATETIME DEFAULT NULL, source VARCHAR(32) NOT NULL, INDEX IDX_7BA2F5EBA76ED395 (user_id), UNIQUE INDEX token_user_unique_idx (user_id, source), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, external_id VARCHAR(255) DEFAULT NULL, sku VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, status VARCHAR(16) NOT NULL, availability VARCHAR(16) NOT NULL, vendor VARCHAR(255) NOT NULL, product_type VARCHAR(64) NOT NULL, tags VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_image (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, external_id VARCHAR(255) DEFAULT NULL, external_product_id VARCHAR(255) DEFAULT NULL, alt VARCHAR(255) DEFAULT NULL, position SMALLINT NOT NULL, width INT NOT NULL, height INT NOT NULL, source VARCHAR(255) NOT NULL, variant_ids LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_64617F034584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_option (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, external_id VARCHAR(255) DEFAULT NULL, external_product_id VARCHAR(255) DEFAULT NULL, name VARCHAR(32) NOT NULL, position INT NOT NULL, option_values LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_38FA41144584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_variant (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, external_id VARCHAR(255) DEFAULT NULL, external_product_id VARCHAR(255) DEFAULT NULL, sku VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, price INT NOT NULL, compare_at_price INT DEFAULT NULL, position INT NOT NULL, weight_in_grams DOUBLE PRECISION NOT NULL, barcode VARCHAR(255) DEFAULT NULL, option1 VARCHAR(32) DEFAULT NULL, option2 VARCHAR(32) DEFAULT NULL, option3 VARCHAR(32) DEFAULT NULL, image_id VARCHAR(255) NOT NULL, inventory_id VARCHAR(255) DEFAULT NULL, inventory_quantity INT DEFAULT NULL, inventory_management VARCHAR(255) DEFAULT NULL, fulfillment_service VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_209AA41D4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE api_token ADD CONSTRAINT FK_7BA2F5EBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_option ADD CONSTRAINT FK_38FA41144584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_variant ADD CONSTRAINT FK_209AA41D4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE api_token DROP FOREIGN KEY FK_7BA2F5EBA76ED395');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A');
        $this->addSql('ALTER TABLE product_option DROP FOREIGN KEY FK_38FA41144584665A');
        $this->addSql('ALTER TABLE product_variant DROP FOREIGN KEY FK_209AA41D4584665A');
        $this->addSql('DROP TABLE api_token');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE product_option');
        $this->addSql('DROP TABLE product_variant');
    }
}
