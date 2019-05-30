toc.dat\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\0000600 0004000 0002000 00000003646 13504202561 0014446 0\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ustar\00postgres\\\\\\\\\\\\\\\\\\\\\\\\postgres\\\\\\\\\\\\\\\\\\\\\\\\0000000 0000000 \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\PGDMP\\\\\\\!\\\\\\\\\\\\\\\\\\\\w\\\\\\\\\\\gnugat_pomm_foundation_bundle\\\\9.6.13\\\\9.6.13\
\\\\m\\\\\\\\\\\0\\\\0\\\\ENCODING\\\\ENCODING\\\\\\\\SET client_encoding = 'UTF8';
\\\\\\\\\\\\\\\\\\\\\\\false\\\\\\\\\n\\\\\\\\\\\0\\\\0\
\\\STDSTRINGS\
\\\STDSTRINGS\\\\\(\\\SET standard_conforming_strings = 'on';
\\\\\\\\\\\\\\\\\\\\\\\false\\\\\\\\\o\\\\\\\\\\\0\\\\0\
\\\SEARCHPATH\
\\\SEARCHPATH\\\\\8\\\SELECT pg_catalog.set_config('search_path', '', false);
\\\\\\\\\\\\\\\\\\\\\\\false\\\\\\\\\p\\\\\\\\\\\1262\\\\1036398\\\\gnugat_pomm_foundation_bundle\\\\DATABASE\\\\\è\\\CREATE DATABASE gnugat_pomm_foundation_bundle WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'en_GB.UTF-8' LC_CTYPE = 'en_GB.UTF-8';
\-\\\DROP DATABASE gnugat_pomm_foundation_bundle;
\\\\\\\\\\\\\postgres\\\\false\\\\\\\\\\\\\\\\\\\\\2615\\\\2200\\\\public\\\\SCHEMA\\\\\\\\CREATE SCHEMA public;
\\\\DROP SCHEMA public;
\\\\\\\\\\\\\postgres\\\\false\\\\\\\\\q\\\\\\\\\\\0\\\\0\\\\SCHEMA public\\\\COMMENT\\\\\6\\\COMMENT ON SCHEMA public IS 'standard public schema';
\\\\\\\\\\\\\\\\\\postgres\\\\false\\\\3\\\\\\\\\\\\\\\\\\\\\3079\\\\12427\\\\plpgsql\	\\\EXTENSION\\\\\?\\\CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
\\\\DROP EXTENSION plpgsql;
\\\\\\\\\\\\\\\\\\false\\\\\\\\\r\\\\\\\\\\\0\\\\0\\\\EXTENSION plpgsql\\\\COMMENT\\\\\@\\\COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
\\\\\\\\\\\\\\\\\\\\\\\false\\\\1\\\\\\\\\π\\\\\\\\\\\\1259\\\\1036399\\\\my_table\\\\TABLE\\\\\"\\\CREATE TABLE public.my_table (
);
\\\\DROP TABLE public.my_table;
\\\\\\\public\\\\\\\\\postgres\\\\false\\\\3\\\\\\\\\j\\\\\\\\\\0\\\\1036399\\\\my_table\
\\\TABLE DATA\\\\\\\\\\\\\\\"\\\COPY public.my_table  FROM stdin;
\\\\public\\\\\\\postgres\\\\false\\\\185\\\\\\\2154.dat\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\2154.dat\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\0000600 0004000 0002000 00000000005 13504202561 0014236 0\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ustar\00postgres\\\\\\\\\\\\\\\\\\\\\\\\postgres\\\\\\\\\\\\\\\\\\\\\\\\0000000 0000000 \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\.


\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\restore.sql\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\0000600 0004000 0002000 00000003140 13504202561 0015360 0\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ustar\00postgres\\\\\\\\\\\\\\\\\\\\\\\\postgres\\\\\\\\\\\\\\\\\\\\\\\\0000000 0000000 \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\--
-- NOTE:
--
-- File paths need to be edited. Search for $$PATH$$ and
-- replace it with the path to the directory containing
-- the extracted data files.
--
--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.13
-- Dumped by pg_dump version 9.6.13

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

DROP TABLE public.my_table;
DROP EXTENSION plpgsql;
DROP SCHEMA public;
--
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO postgres;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner:
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner:
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: my_table; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.my_table (
);


ALTER TABLE public.my_table OWNER TO postgres;

--
-- Data for Name: my_table; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.my_table  FROM stdin;
\.
COPY public.my_table  FROM '$$PATH$$/2154.dat';

--
-- PostgreSQL database dump complete
--

\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
