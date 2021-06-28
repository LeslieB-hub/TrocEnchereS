<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210628204550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC0056C755722');
        $this->addSql('DROP INDEX IDX_E54BC0056C755722 ON sale');
        $this->addSql('ALTER TABLE sale ADD buyer_user_id INT DEFAULT NULL, DROP buyer_id');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC0057C27AE3 FOREIGN KEY (buyer_user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_E54BC0057C27AE3 ON sale (buyer_user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC0057C27AE3');
        $this->addSql('DROP INDEX IDX_E54BC0057C27AE3 ON sale');
        $this->addSql('ALTER TABLE sale ADD buyer_id INT NOT NULL, DROP buyer_user_id');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC0056C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E54BC0056C755722 ON sale (buyer_id)');
    }
}
