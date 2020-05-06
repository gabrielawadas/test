<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200506104611 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action ADD wallet_id INT DEFAULT NULL, ADD category_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C9212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92712520F3 ON action (wallet_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C9212469DE2 ON action (category_id)');
        $this->addSql('ALTER TABLE wallet CHANGE balance balance INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92712520F3');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C9212469DE2');
        $this->addSql('DROP INDEX IDX_47CC8C92712520F3 ON action');
        $this->addSql('DROP INDEX IDX_47CC8C9212469DE2 ON action');
        $this->addSql('ALTER TABLE action DROP wallet_id, DROP category_id, CHANGE name name VARCHAR(45) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE wallet CHANGE balance balance INT UNSIGNED NOT NULL');
    }
}
