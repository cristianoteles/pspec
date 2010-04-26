<?php
namespace PSpec\Spec;
include "fixtures/Classe.php";

describe('Classe', function(){
    describe('Atributos Públicos', function() {

        $objeto = new Classe;
        $objeto->setTodosSabem(5);
        $objeto->setSegredo(9);

        it('devem poder ser acessados externamente.', function() use($objeto) {
            expect( isset($objeto->todosSabem) )->should('be equals',false);
            expect( isset($objeto->segredo) )->should('be equals', false);
        });

        it('devem poder ser acessados externamente.', function() use($objeto) {
            expect( isset($objeto->todosSabem) )->should('be equals',true);
            expect( isset($objeto->segredo) )->should('be equals', false);
        });

        it('teste incompleto.', function() use($objeto) {

        });

        it('"todos sabem" deve ser entre 20 e 30.', function() use($objeto) {
            $objeto->setTodosSabem(22);
            expect($objeto->getTodosSabem())->should('be between', 20, 30);
        });

        it('teste erro.', function() use($objeto) {
            $dois = $um + 1;
        });
    });
});