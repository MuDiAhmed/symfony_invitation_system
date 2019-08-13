<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190813035716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invitaion ADD sender_id INT NOT NULL, ADD receiver_id INT NOT NULL');
        $this->addSql('ALTER TABLE invitaion ADD CONSTRAINT FK_F34A37AAF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invitaion ADD CONSTRAINT FK_F34A37AACD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F34A37AAF624B39D ON invitaion (sender_id)');
        $this->addSql('CREATE INDEX IDX_F34A37AACD53EDB6 ON invitaion (receiver_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6495A6F1243');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EC1EC211');
        $this->addSql('DROP INDEX IDX_8D93D649EC1EC211 ON user');
        $this->addSql('DROP INDEX IDX_8D93D6495A6F1243 ON user');
        $this->addSql('ALTER TABLE user DROP invitaions_id, DROP invitations_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE invitaion DROP FOREIGN KEY FK_F34A37AAF624B39D');
        $this->addSql('ALTER TABLE invitaion DROP FOREIGN KEY FK_F34A37AACD53EDB6');
        $this->addSql('DROP INDEX IDX_F34A37AAF624B39D ON invitaion');
        $this->addSql('DROP INDEX IDX_F34A37AACD53EDB6 ON invitaion');
        $this->addSql('ALTER TABLE invitaion DROP sender_id, DROP receiver_id');
        $this->addSql('ALTER TABLE user ADD invitaions_id INT DEFAULT NULL, ADD invitations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6495A6F1243 FOREIGN KEY (invitations_id) REFERENCES invitaion (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EC1EC211 FOREIGN KEY (invitaions_id) REFERENCES invitaion (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649EC1EC211 ON user (invitaions_id)');
        $this->addSql('CREATE INDEX IDX_8D93D6495A6F1243 ON user (invitations_id)');
    }
}
