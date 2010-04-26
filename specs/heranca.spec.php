<?php
namespace PSpec\Spec;
include_once "fixtures/Classe.php";
include_once "fixtures/ClasseFilha.php";

describe('Herança', function() {

    $objetoDaClasseFilha = new ClasseFilha;

    it('objeto da classe filha deve ser do tipo da classe mãe.', function() use($objetoDaClasseFilha) {
        expect( $objetoDaClasseFilha )->should('be an instance of','PSpec\Spec\Classe');
    });
    
    it('objeto da classe filha deve ser também do tipo da classe filha.', function() use($objetoDaClasseFilha) {
        expect( $objetoDaClasseFilha )->should('be an instance of','PSpec\Spec\ClasseFilha');
    });

});
