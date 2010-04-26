<?php
namespace PSpec\Spec;
describe('PSpec', function() {
    describe('PSpec', function() {
        $pspec = \PSpec\PSpec::build();
        $testDescName = 'test';
        
        it('getInstance() deve retornar instancia de PSpec.', function() use($pspec, $testDescName) {
            expect( $pspec )->should('be an instance of','\PSpec\PSpec');
        });

        describe('addDescription()', function() use($pspec, $testDescName) {
            it('deve retornar instancia de PSpec.', function() use($pspec, $testDescName) {
                expect( $pspec->addDescription($testDescName) )->should('be an instance of','\PSpec\PSpec');
                $pspec->clearDescriptions();
            });

            it('deve adicionar uma especificação.', function() use($pspec, $testDescName) {
                $pspec->addDescription($testDescName);
                expect( $pspec->hasDescription($testDescName) )->should('be equals',true);
                $pspec->clearDescriptions();
            });
            
            it('deve lançar exceção se a especificação não existir.', function() use($pspec, $testDescName) {
                expectException('InvalidArgumentException');
                $pspec->addDescription('testnaoexiste');
            });
        });

        it('clearDescriptions() deve limpar todas as descrições', function() use($pspec, $testDescName) {
            $pspec->addDescription($testDescName)->clearDescriptions();
            expect( $pspec->hasDescription($testDescName) )->should('be equals',false);
        });
        
        describe('run()', function() use($pspec, $testDescName) {
            it('deve retornar o mesmo número de resultados de primeiro nível que o número de descrições.', function() use($pspec, $testDescName) {
                $resultGroup =
                    $pspec->clearDescriptions()
                        ->addDescription($testDescName)
                        ->addDescription('test2')
                        ->run();
                expect($resultGroup->countResults())->should('be equals',2);
            });
            
            it('deve ter um array de SpecResult nos resultados de primeiro nível', function() use($pspec, $testDescName) {
                $resultGroup = $pspec->addDescription($testDescName)->run();
                expect($resultGroup)->should('only have instances of', '\PSpec\SpecResult');
            });
            
            it('deve definir o SpecData em todos os resultados de primeiro nível', function() use($pspec, $testDescName) {
                $resultGroup = $pspec->clearDescriptions()->addDescription($testDescName)->run();
                foreach($resultGroup as $result) {
                    expect($result->getSpecData())->should('be an instance of', '\PSpec\SpecData');
                }
            });
        });
    });
});