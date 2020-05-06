<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200429184141 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE action ADD category_id INT DEFAULT NULL, CHANGE wallet_id wallet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C92C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE action ADD CONSTRAINT FK_47CC8C9212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_47CC8C92C54C8C93 ON action (type_id)');
        $this->addSql('CREATE INDEX IDX_47CC8C9212469DE2 ON action (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C9212469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('ALTER TABLE action DROP FOREIGN KEY FK_47CC8C92C54C8C93');
        $this->addSql('DROP INDEX IDX_47CC8C92C54C8C93 ON action');
        $this->addSql('DROP INDEX IDX_47CC8C9212469DE2 ON action');
        $this->addSql('ALTER TABLE action DROP category_id, CHANGE wallet_id wallet_id INT NOT NULL');
    }
}
