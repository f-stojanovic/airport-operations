<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211020164914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE aircraft_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cron_job_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cron_report_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ground_crew_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE logs_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE weather_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE aircraft (id INT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, call_sign VARCHAR(255) DEFAULT NULL, latitude VARCHAR(255) DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, altitude INT DEFAULT NULL, heading INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cron_job (id INT NOT NULL, name VARCHAR(191) NOT NULL, command VARCHAR(1024) NOT NULL, schedule VARCHAR(191) NOT NULL, description VARCHAR(191) NOT NULL, enabled BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX un_name ON cron_job (name)');
        $this->addSql('CREATE TABLE cron_report (id INT NOT NULL, job_id INT DEFAULT NULL, run_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, run_time DOUBLE PRECISION NOT NULL, exit_code INT NOT NULL, output TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6C6A7F5BE04EA9 ON cron_report (job_id)');
        $this->addSql('CREATE TABLE ground_crew (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE logs (id INT NOT NULL, aircraft INT DEFAULT NULL, ground_crew INT DEFAULT NULL, name VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, time_of_change VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F08FC65C13D96729 ON logs (aircraft)');
        $this->addSql('CREATE INDEX IDX_F08FC65CDD1C0B33 ON logs (ground_crew)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON DEFAULT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE weather (id INT NOT NULL, description VARCHAR(255) NOT NULL, temperature VARCHAR(255) NOT NULL, visibility VARCHAR(255) NOT NULL, wind_speed VARCHAR(255) NOT NULL, wind_dag VARCHAR(255) NOT NULL, last_update VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE cron_report ADD CONSTRAINT FK_B6C6A7F5BE04EA9 FOREIGN KEY (job_id) REFERENCES cron_job (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE logs ADD CONSTRAINT FK_F08FC65C13D96729 FOREIGN KEY (aircraft) REFERENCES aircraft (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE logs ADD CONSTRAINT FK_F08FC65CDD1C0B33 FOREIGN KEY (ground_crew) REFERENCES ground_crew (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE logs DROP CONSTRAINT FK_F08FC65C13D96729');
        $this->addSql('ALTER TABLE cron_report DROP CONSTRAINT FK_B6C6A7F5BE04EA9');
        $this->addSql('ALTER TABLE logs DROP CONSTRAINT FK_F08FC65CDD1C0B33');
        $this->addSql('DROP SEQUENCE aircraft_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cron_job_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cron_report_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ground_crew_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE logs_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE weather_id_seq CASCADE');
        $this->addSql('DROP TABLE aircraft');
        $this->addSql('DROP TABLE cron_job');
        $this->addSql('DROP TABLE cron_report');
        $this->addSql('DROP TABLE ground_crew');
        $this->addSql('DROP TABLE logs');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE weather');
    }
}
