**<h2>Projeto ACCEPT Cesae Digital - Projeto Final</h2>**
<h4>Nome do Projeto - TrainerApp</h4>
<h4>Grupo - Ana Neves (TL), Marcelo Valente & Tiago Morgado</h4>
<h4>Cliente - João Câncio</h4>

<br>

**<h4>Em que consistiu o projeto?**</h4>
O projeto passou por desenvolver uma plataforma que permitisse toda a gestão do dia-adia de um formador – desde as ferramentas necessárias para se organizar em aula (material de apoio, registo de alunos), à gestão logística (registo de instituições, cursos e módulos ensinados), à gestão administrativa (documentos legais necessários para dar formação em Portugal) e finalmente, à gestão financeira (faturação, ganhos efetivos).

**<h4>Quais eram os principais objetivos e requisitos do cliente?</h4>**
Os principais objetivos do cliente era que fosse uma plataforma fácil e intuitiva de
trabalhar mas ao mesmo tempo, completa.
<br>Era importante haver uma forma de rastrear toda a atividade financeira relativa ao exercício da formação - como parte deste pedido, o cliente demonstrou interesse em ter registo da faturação total, ganhos efetivos e a possibilidade de poder visualmente perceber a diferença da faturação entre entidades.
<br>Relativamente à gestão administrativa, existia a necessidade de selecionar vários documentos legais (seguro, registo criminal, cópia do CC) e efetuar o download mesclado. 
<br>O calendário deve ser intuitivo, e permitir a sua utilização duma forma simples. Se possível, distinção com cores por curso ou módulo ou instituição, de modo a facilitar o seu reconhecimento.
<br>A nível de organização de aulas, foi solicitado que existisse uma forma de registar os alunos e atribuir uma nota final.
<br>Também a possibilidade de registar os cursos, instituições e módulos foi algo imperativo para o funcionamento da aplicação.

**<h4>Ferramentas utililizadas para realização do projeto</h4>**
Laravel, PHP, JS, HTML, CSS || MySQL || Jira || Figma
<br>Implementamos também o FullCalendar e utilizamos bibliotecas como Bootstrap e Charts. 

**<h4>Como estruturamos o projeto?</h4>**
1. BD – diagrama ER, modelo de Dados & criação de BD no Laravel/MySQL
<br>2. Figma – elaboração do layout visual
<br>3. Front & Back integrados
<br>3.1. Front-End - Distribuição das páginas por todos os elementos: Ana (Página Gestão Financeira), Marcelo (Página Instituições, Cursos, Módulos & Documentos) & Tiago (Páginas Aluno, Dashboard & Calendário). A página de Login foi distribuída por todos – layout no CodePen (Ana), desenvolvimento Front (Tiago), desenvolvimento back (Marcelo).
<br>3.2. Back-End – Desenvolvimento de todas as funcionalidades de cada página
e ligação com BD.

**<h4>Limitações/Dificuldades sentidas</h4>**
A BD estruturada inicialmente sofreu várias alterações, por necessidade de novas tabelas e atributos. Isso acabou por dificultar e atrasar o nosso processo de integração dos dados no Back e trazê-los para o Front. Esta dificuldade foi sentida por todos os membros do grupo.
<br>Devido à falta de oportunidade de nos reunirmos com o nosso cliente mais frequentemente, tivemos que tomar algumas decisões com base na informação que nos foi passada nas reuniões iniciais - o valor expectável na página de gestão financeira foi calculado com base nos agendamentos do calendário (com filtro respetivo aplicado - este mês, último mês, trimestre ou todos). Esta decisão foi tomada de forma a manter a consistência e exatidão dos dados na página. 
<br>Sentimos também dificuldade em implementar a conversão para PDF e em ajustar a estrutura para que o download conjunto e o preview funcionassem corretamente. Apesar de estar funcional, exigiu-se mudanças na forma como os documentos estavam organizados.
<br>Também houve maior complexidade na implementação da busca e edição, porque os elementos já relacionados precisavam de vir assinalados no modal. Apesar de resolvido, estas partes foram mais trabalhosas e poderiam ser otimizadas no futuro.
<br>Foi desafiante importar o full calendar para o nosso projeto, uma vez que nunca tínhamos tido contacto com o mesmo. Foi necessário fazer alterações a nível do css e JavaScript do projeto Full Calendar, que já existia. 

**<h4>Objetivos cumpridos</h4>**
Conseguimos cumprir todos os pedidos essenciais do cliente. O projeto tem a possibilidade de ser escalado e existem claro coisas que podem ser melhoradas. 
No entanto, a plataforma tem uma navegação fácil, intuitiva e completa. 

**<h4>Algumas futuras adições</h4>**
Relativamente à página de gestão financeira, podem ser adicionados mais filtros - faturação por curso, faturação por módulo, faturação anual.
<br>Relativamente à página alunos, podem ser adicionadas funcionalidades como presenças/ausências, comportamento, participação, entre outras. 

**<h4>Feedback entre Equipa</h4>**
Equipa proativa, dinâmica e comunicativa. Houve contacto diários entre todos os membros da equipa e uma troca constante de ideias. Capacidade de flexibilizar o que faz sentido incluir no projeto e o que não faz. Equipa bastante autónoma na realização das suas tarefas.
