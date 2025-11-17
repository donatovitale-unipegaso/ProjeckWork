CREATE DATABASE unipegaso_progetto;
--
-- PostgreSQL database dump
--

-- Dumped from database version 16.9 (Debian 16.9-1.pgdg120+1)
-- Dumped by pg_dump version 16.9 (Debian 16.9-1.pgdg120+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;


\connect unipegaso_progetto
--
-- Name: feedback; Type: TABLE; Schema: public; Owner: unipegaso
--

CREATE TABLE public.feedback (
    id integer NOT NULL,
    username character varying(100) NOT NULL,
    rating integer NOT NULL,
    comment text,
    submitted_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT feedback_rating_check CHECK (((rating >= 1) AND (rating <= 5)))
);


ALTER TABLE public.feedback OWNER TO unipegaso;

--
-- Name: feedback_id_seq; Type: SEQUENCE; Schema: public; Owner: unipegaso
--

CREATE SEQUENCE public.feedback_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.feedback_id_seq OWNER TO unipegaso;

--
-- Name: feedback_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: unipegaso
--

ALTER SEQUENCE public.feedback_id_seq OWNED BY public.feedback.id;


--
-- Name: quiz_questions; Type: TABLE; Schema: public; Owner: unipegaso
--

CREATE TABLE public.quiz_questions (
    id integer NOT NULL,
    question text NOT NULL,
    option1 text NOT NULL,
    option2 text NOT NULL,
    option3 text NOT NULL,
    option4 text NOT NULL,
    correct_option integer NOT NULL,
    CONSTRAINT quiz_questions_correct_option_check CHECK (((correct_option >= 1) AND (correct_option <= 4)))
);


ALTER TABLE public.quiz_questions OWNER TO unipegaso;

--
-- Name: quiz_questions_id_seq; Type: SEQUENCE; Schema: public; Owner: unipegaso
--

CREATE SEQUENCE public.quiz_questions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.quiz_questions_id_seq OWNER TO unipegaso;

--
-- Name: quiz_questions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: unipegaso
--

ALTER SEQUENCE public.quiz_questions_id_seq OWNED BY public.quiz_questions.id;


--
-- Name: quiz_results; Type: TABLE; Schema: public; Owner: unipegaso
--

CREATE TABLE public.quiz_results (
    id integer NOT NULL,
    username character varying(100) NOT NULL,
    score integer NOT NULL,
    total_questions integer NOT NULL,
    submitted_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.quiz_results OWNER TO unipegaso;

--
-- Name: quiz_results_id_seq; Type: SEQUENCE; Schema: public; Owner: unipegaso
--

CREATE SEQUENCE public.quiz_results_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.quiz_results_id_seq OWNER TO unipegaso;

--
-- Name: quiz_results_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: unipegaso
--

ALTER SEQUENCE public.quiz_results_id_seq OWNED BY public.quiz_results.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: unipegaso
--

CREATE TABLE public.users (
    id integer NOT NULL,
    username character varying(100) NOT NULL,
    password text NOT NULL,
    email character varying(255)
);


ALTER TABLE public.users OWNER TO unipegaso;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: unipegaso
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO unipegaso;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: unipegaso
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: feedback id; Type: DEFAULT; Schema: public; Owner: unipegaso
--

ALTER TABLE ONLY public.feedback ALTER COLUMN id SET DEFAULT nextval('public.feedback_id_seq'::regclass);


--
-- Name: quiz_questions id; Type: DEFAULT; Schema: public; Owner: unipegaso
--

ALTER TABLE ONLY public.quiz_questions ALTER COLUMN id SET DEFAULT nextval('public.quiz_questions_id_seq'::regclass);


--
-- Name: quiz_results id; Type: DEFAULT; Schema: public; Owner: unipegaso
--

ALTER TABLE ONLY public.quiz_results ALTER COLUMN id SET DEFAULT nextval('public.quiz_results_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: unipegaso
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: feedback; Type: TABLE DATA; Schema: public; Owner: unipegaso
--

COPY public.feedback (id, username, rating, comment, submitted_at) FROM stdin;
22	mario	4	Percorso formativo completo ed efficace	2025-11-15 10:26:54.768225
\.


--
-- Data for Name: quiz_questions; Type: TABLE DATA; Schema: public; Owner: unipegaso
--

COPY public.quiz_questions (id, question, option1, option2, option3, option4, correct_option) FROM stdin;
1	Che cosa si intende per rischio nella sicurezza aziendale?	La combinazione tra probabilità di un evento dannoso e gravità del danno	Il numero di infortuni avvenuti in un anno	L insieme di tutte le procedure aziendali	La sola presenza di pericoli nell ambiente di lavoro	1
2	Che cosa è il pericolo secondo la definizione della valutazione dei rischi?	La probabilità che avvenga un incidente	La proprietà intrinseca di un fattore di causare un danno	L elenco degli infortuni aziendali	Il documento di valutazione dei rischi	2
3	Quale tra i seguenti è un esempio di rischio generico?	L uso di una sostanza chimica altamente tossica in laboratorio	L esposizione prolungata a rumore elevato in reparto produttivo	Il rischio di scivolare su un pavimento bagnato presente in molti ambienti	La manutenzione di un impianto elettrico ad alta tensione	3
4	Qual è la formula di base del modello a matrice per la valutazione del rischio?	R = M + P	R = P x D	R = D ÷ P	R = P - D	2
5	Secondo il modello a matrice, quando il valore del rischio R è maggiore di 8:	Il rischio è trascurabile e non richiede interventi	Il rischio è medio basso e richiede solo monitoraggio nel lungo periodo	Il rischio è significativo o grave e occorre intervenire con estrema urgenza	Il rischio non rientra nell ambito del DVR	3
6	Quale documento raccoglie in modo sistematico l analisi dei pericoli e dei rischi aziendali?	Il Documento di Valutazione dei Rischi (DVR)	Il bilancio di esercizio	Il manuale qualità ISO 9001	Il registro presenze del personale	1
7	In quale situazione è obbligatorio aggiornare il DVR entro 30 giorni?	Quando termina l anno solare	Quando cambia il responsabile del personale senza altre modifiche	Quando vi sono modifiche ai processi o all organizzazione che introducono nuovi rischi	Quando l azienda partecipa a un audit volontario	3
8	Quale tra i seguenti è un esempio di misura di prevenzione nella mitigazione del rischio?	Utilizzo di caschi e guanti di protezione	Installazione di barriere fisiche di contenimento	Formazione e addestramento del personale sulle procedure sicure	Uso di estintori in caso di incendio già in corso	3
9	Quali sono le tre proprietà fondamentali della sicurezza informatica aziendale?	Riservatezza, Integrità, Disponibilità	Rapidità, Efficienza, Economicità	Ridondanza, Flessibilità, Scalabilità	Conformità, Tracciabilità, Auditabilità	1
10	In ambito di rischio informatico, quale azione correttiva è adeguata se il rischio riguarda il mancato backup settimanale?	Disattivare i controlli di accesso per velocizzare il lavoro	Eseguire backup automatici e programmati dei dati	Conservare tutti i dati solo su supporti locali non ridondati	Affidarsi esclusivamente alla memoria degli operatori	2
\.


--
-- Data for Name: quiz_results; Type: TABLE DATA; Schema: public; Owner: unipegaso
--

COPY public.quiz_results (id, username, score, total_questions, submitted_at) FROM stdin;
1	mario	9	10	2025-11-15 10:25:20.367477
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: unipegaso
--

COPY public.users (id, username, password, email) FROM stdin;
1	mario	$2y$10$/8eua6N4c0u86V5qOEVxeO4Pg6/v1LNSb7.p5erx9qV7bqI4m5ZMy	mario.rossi@gmail.com
\.


--
-- Name: feedback_id_seq; Type: SEQUENCE SET; Schema: public; Owner: unipegaso
--

SELECT pg_catalog.setval('public.feedback_id_seq', 22, true);


--
-- Name: quiz_questions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: unipegaso
--

SELECT pg_catalog.setval('public.quiz_questions_id_seq', 1, false);


--
-- Name: quiz_results_id_seq; Type: SEQUENCE SET; Schema: public; Owner: unipegaso
--

SELECT pg_catalog.setval('public.quiz_results_id_seq', 7, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: unipegaso
--

SELECT pg_catalog.setval('public.users_id_seq', 16, true);


--
-- Name: feedback feedback_pkey; Type: CONSTRAINT; Schema: public; Owner: unipegaso
--

ALTER TABLE ONLY public.feedback
    ADD CONSTRAINT feedback_pkey PRIMARY KEY (id);


--
-- Name: quiz_questions quiz_questions_pkey; Type: CONSTRAINT; Schema: public; Owner: unipegaso
--

ALTER TABLE ONLY public.quiz_questions
    ADD CONSTRAINT quiz_questions_pkey PRIMARY KEY (id);


--
-- Name: quiz_results quiz_results_pkey; Type: CONSTRAINT; Schema: public; Owner: unipegaso
--

ALTER TABLE ONLY public.quiz_results
    ADD CONSTRAINT quiz_results_pkey PRIMARY KEY (id);


--
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: unipegaso
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: unipegaso
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users users_username_key; Type: CONSTRAINT; Schema: public; Owner: unipegaso
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_username_key UNIQUE (username);


--
-- Name: quiz_results quiz_results_username_fkey; Type: FK CONSTRAINT; Schema: public; Owner: unipegaso
--

ALTER TABLE ONLY public.quiz_results
    ADD CONSTRAINT quiz_results_username_fkey FOREIGN KEY (username) REFERENCES public.users(username) ON DELETE CASCADE;


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: pg_database_owner
--

GRANT ALL ON SCHEMA public TO unipegaso;


--
-- Name: TABLE feedback; Type: ACL; Schema: public; Owner: unipegaso
--

GRANT SELECT ON TABLE public.feedback TO unipegaso_progetto_ro;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.feedback TO unipegaso_progetto_crud;


--
-- Name: TABLE quiz_questions; Type: ACL; Schema: public; Owner: unipegaso
--

GRANT SELECT ON TABLE public.quiz_questions TO unipegaso_progetto_ro;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.quiz_questions TO unipegaso_progetto_crud;


--
-- Name: TABLE quiz_results; Type: ACL; Schema: public; Owner: unipegaso
--

GRANT SELECT ON TABLE public.quiz_results TO unipegaso_progetto_ro;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.quiz_results TO unipegaso_progetto_crud;


--
-- Name: TABLE users; Type: ACL; Schema: public; Owner: unipegaso
--

GRANT SELECT ON TABLE public.users TO unipegaso_progetto_ro;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE public.users TO unipegaso_progetto_crud;


--
-- Name: DEFAULT PRIVILEGES FOR TABLES; Type: DEFAULT ACL; Schema: public; Owner: unipegaso
--

ALTER DEFAULT PRIVILEGES FOR ROLE unipegaso IN SCHEMA public GRANT SELECT ON TABLES TO unipegaso_progetto_ro;
ALTER DEFAULT PRIVILEGES FOR ROLE unipegaso IN SCHEMA public GRANT SELECT,INSERT,DELETE,UPDATE ON TABLES TO unipegaso_progetto_crud;


--
-- PostgreSQL database dump complete
--

