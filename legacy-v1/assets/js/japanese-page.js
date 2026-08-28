import { QUIZ_QUESTIONS, checkAnswer } from './quiz.js';
const root=document.querySelector('#quiz-root');
let index=0, score=0;
function draw(){
  if(!root) return;
  root.replaceChildren();
  if(index>=QUIZ_QUESTIONS.length){
    const h=document.createElement('h3'); h.textContent='Quiz terminé 🎉';
    const p=document.createElement('p'); p.textContent=`Score : ${score}/${QUIZ_QUESTIONS.length}`;
    const b=document.createElement('button'); b.className='button'; b.textContent='Recommencer'; b.addEventListener('click',()=>{index=0;score=0;draw();}); root.append(h,p,b); return;
  }
  const q=QUIZ_QUESTIONS[index];
  const progress=document.createElement('span'); progress.className='badge'; progress.textContent=`Question ${index+1}/${QUIZ_QUESTIONS.length}`;
  const h=document.createElement('h3'); h.textContent=q.prompt;
  const opts=document.createElement('div'); opts.className='quiz-options';
  q.choices.forEach((choice,i)=>{ const b=document.createElement('button'); b.type='button'; b.textContent=choice; b.addEventListener('click',()=>answer(i,opts,q)); opts.append(b); });
  root.append(progress,h,opts);
}
function answer(choice,opts,q){
  const result=checkAnswer(q,choice); if(result.correct) score++;
  opts.querySelectorAll('button').forEach(b=>b.disabled=true);
  const feedback=document.createElement('p'); feedback.className=result.correct?'callout':'notice'; feedback.textContent=`${result.correct?'Bonne réponse !':'Pas tout à fait.'} ${result.explanation}`;
  const next=document.createElement('button'); next.className='button button--small'; next.textContent=index===QUIZ_QUESTIONS.length-1?'Voir mon score':'Question suivante'; next.addEventListener('click',()=>{index++;draw();});
  root.append(feedback,next);
}
draw();
