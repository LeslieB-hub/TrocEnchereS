<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210152227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bid (id INT AUTO_INCREMENT NOT NULL, sale_id INT NOT NULL, buyer_id INT NOT NULL, bid_date DATETIME NOT NULL, amount INT NOT NULL, INDEX IDX_4AF2B3F34A7E4868 (sale_id), INDEX IDX_4AF2B3F36C755722 (buyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, seller_id INT NOT NULL, withdrawal_place_id INT DEFAULT NULL, buyer_id INT DEFAULT NULL, state_id INT NOT NULL, item VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, start_date_bid DATE NOT NULL, end_date_bid DATE NOT NULL, initial_price INT DEFAULT NULL, sale_price INT DEFAULT NULL, INDEX IDX_E54BC00512469DE2 (category_id), INDEX IDX_E54BC0058DE820D9 (seller_id), UNIQUE INDEX UNIQ_E54BC00575C4AAC2 (withdrawal_place_id), INDEX IDX_E54BC0056C755722 (buyer_id), INDEX IDX_E54BC0055D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, email VARCHAR(20) NOT NULL, telephone VARCHAR(15) DEFAULT NULL, street VARCHAR(50) DEFAULT NULL, postcode VARCHAR(10) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, balance INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE withdrawal (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(50) NOT NULL, postcode VARCHAR(15) NOT NULL, city VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bid ADD CONSTRAINT FK_4AF2B3F34A7E4868 FOREIGN KEY (sale_id) REFERENCES sale (id)');
        $this->addSql('ALTER TABLE bid ADD CONSTRAINT FK_4AF2B3F36C755722 FOREIGN KEY (buyer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC00512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC0058DE820D9 FOREIGN KEY (seller_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC00575C4AAC2 FOREIGN KEY (withdrawal_place_id) REFERENCES withdrawal (id)');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC0056C755722 FOREIGN KEY (buyer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC0055D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC00512469DE2');
        $this->addSql('ALTER TABLE bid DROP FOREIGN KEY FK_4AF2B3F34A7E4868');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC0055D83CC1');
        $this->addSql('ALTER TABLE bid DROP FOREIGN KEY FK_4AF2B3F36C755722');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC0058DE820D9');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC0056C755722');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC00575C4AAC2');
        $this->addSql('DROP TABLE bid');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE sale');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE withdrawal');
    }
}
