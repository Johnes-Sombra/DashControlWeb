<?php
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase {
    private $db;
    
    protected function setUp(): void {
        $this->db = new Database();
    }
    
    public function testDatabaseConnection() {
        $this->assertNotNull($this->db->getAuthConnection());
        $this->assertNotNull($this->db->getMainConnection());
    }
    
    public function testLoginAttempts() {
        $usuario = 'test_user_' . time();
        
        // Deve permitir primeira tentativa
        $this->assertTrue($this->db->checkLoginAttempts($usuario));
        
        // Registrar tentativas falhas
        for ($i = 0; $i < 3; $i++) {
            $this->db->recordLoginAttempt($usuario, false);
        }
        
        // Deve estar bloqueado após 3 tentativas
        $this->assertFalse($this->db->checkLoginAttempts($usuario));
    }
}