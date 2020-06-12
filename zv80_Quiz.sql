drop table zv80_User cascade constraints;

create table zv80_User
(
   user_id integer,
   username varchar2(15),
   answer_one integer,
   answer_two varchar2(5) check(answer_two in('true', 'false')),
   answer_three char(7),
   answer_four varchar2(5) check(answer_four in('true', 'false')),
   answer_five varchar2(10) check(answer_five in('sharingan', 'tenseigan',
                                                 'third eye', 'wood style')),
   answer_six varchar2(14) check(answer_six in('gamabunta','son goku', 'kurama', 'gyuuki')),
   primary key (user_id)
);
