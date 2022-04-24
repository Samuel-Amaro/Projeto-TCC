--
-- PostgreSQL database dump
--

-- Dumped from database version 12.2
-- Dumped by pg_dump version 12.2

-- Started on 2022-04-24 15:58:02

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

--
-- TOC entry 234 (class 1255 OID 123873)
-- Name: gera_logs_beneficiarios(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.gera_logs_beneficiarios() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_beneficiarios(operacao, valores_novos, valores_velhos, id_beneficiario, id_usuario) VALUES(TG_OP, NEW::TEXT, '', NEW.id_beneficiario, NEW.fk_usuario); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_beneficiarios(operacao, valores_novos, valores_velhos, id_beneficiario, id_usuario) VALUES(TG_OP, NEW::TEXT, OLD::TEXT, NEW.id_beneficiario, NEW.fk_usuario); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_beneficiarios(operacao, valores_novos, valores_velhos, id_beneficiario, id_usuario) VALUES(TG_OP, OLD::TEXT, '', OLD.id_beneficiario, OLD.fk_usuario);
        RETURN OLD;
    END IF;
END;
$$;


ALTER FUNCTION public.gera_logs_beneficiarios() OWNER TO postgres;

--
-- TOC entry 236 (class 1255 OID 124049)
-- Name: gera_logs_beneficios(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.gera_logs_beneficios() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_beneficios(operacao, valores_novos, valores_velhos, id_beneficio, id_fornecedor_doador, id_categoria) VALUES(TG_OP, NEW::TEXT, '', NEW.id_beneficio, NEW.id_fornecedor_doador, NEW.id_categoria); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_beneficios(operacao, valores_novos, valores_velhos, id_beneficio, id_fornecedor_doador, id_categoria) VALUES(TG_OP, NEW::TEXT, OLD::TEXT, NEW.id_beneficio, NEW.id_fornecedor_doador, NEW.id_categoria); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_beneficios(operacao, valores_novos, valores_velhos, id_beneficio, id_fornecedor_doador, id_categoria) VALUES(TG_OP, OLD::TEXT, '', OLD.id_beneficio, NEW.id_fornecedor_doador, NEW.id_categoria);
        RETURN OLD;
    END IF;
END;
$$;


ALTER FUNCTION public.gera_logs_beneficios() OWNER TO postgres;

--
-- TOC entry 237 (class 1255 OID 124051)
-- Name: gera_logs_estoque(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.gera_logs_estoque() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_movimentacoes_beneficios(id_estoque, operacao, valores_velhos, valores_novos, id_beneficio) VALUES(NEW.id_estoque, TG_OP, NEW::TEXT, '', NEW.id_beneficio); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN INSERT INTO log_movimentacoes_beneficios(id_estoque, operacao, valores_velhos, valores_novos, id_beneficio) VALUES(NEW.id_estoque, TG_OP, NEW::TEXT, OLD::TEXT, NEW.id_beneficio); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_movimentacoes_beneficios(id_estoque, operacao, valores_velhos, valores_novos, id_beneficio) VALUES( OLD.id_estoque, TG_OP, OLD::TEXT, '', NEW.id_beneficio);
        RETURN OLD;
    END IF;
END;
$$;


ALTER FUNCTION public.gera_logs_estoque() OWNER TO postgres;

--
-- TOC entry 235 (class 1255 OID 123919)
-- Name: gera_logs_fornecedores_doadores(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.gera_logs_fornecedores_doadores() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_fornecedores_doadores(operacao, valores_novos, valores_velhos, id_fornecedor_doador) VALUES(TG_OP, NEW::TEXT, '', NEW.id); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_fornecedores_doadores(operacao, valores_novos, valores_velhos, id_fornecedor_doador) VALUES(TG_OP, NEW::TEXT, OLD::TEXT, NEW.id); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_fornecedores_doadores(operacao, valores_novos, valores_velhos, id_fornecedor_doador) VALUES(TG_OP, OLD::TEXT, '', OLD.id);
        RETURN OLD;
    END IF;
END;
$$;


ALTER FUNCTION public.gera_logs_fornecedores_doadores() OWNER TO postgres;

--
-- TOC entry 233 (class 1255 OID 123741)
-- Name: gera_logs_usuarios(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.gera_logs_usuarios() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN 
        INSERT INTO log_usuarios(operacao, valores_novos, valores_Velhos, usuario) VALUES (TG_OP, NEW::TEXT, '', NEW.id_usuario);
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_usuarios(operacao, valores_novos, valores_velhos, usuario) VALUES (TG_OP, NEW::TEXT, OLD::TEXT, NEW.id_usuario);
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_usuarios(operacao, valores_novos, valores_velhos, usuario) VALUES (TG_OP, OLD::TEXT, '', OLD.id_usuario);
        RETURN OLD;
    END IF;
END;
$$;


ALTER FUNCTION public.gera_logs_usuarios() OWNER TO postgres;

--
-- TOC entry 254 (class 1255 OID 124259)
-- Name: registra_logs_beneficio(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.registra_logs_beneficio() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, OLD::TEXT, NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', OLD::TEXT, TG_TABLE_NAME, NULL);
        RETURN OLD;
    END IF;
END;
$$;


ALTER FUNCTION public.registra_logs_beneficio() OWNER TO postgres;

--
-- TOC entry 253 (class 1255 OID 124225)
-- Name: registra_logs_entregas_beneficios(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.registra_logs_entregas_beneficios() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', NEW::TEXT, TG_TABLE_NAME, NEW.id_usuario_responsavel_entrega); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, OLD::TEXT, NEW::TEXT, TG_TABLE_NAME, OLD.id_usuario_responsavel_entrega); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', OLD::TEXT, TG_TABLE_NAME, OLD.id_usuario_responsavel_entrega);
        RETURN OLD;
    END IF;
END;
$$;


ALTER FUNCTION public.registra_logs_entregas_beneficios() OWNER TO postgres;

--
-- TOC entry 251 (class 1255 OID 124165)
-- Name: registra_logs_fornecimento_doacao_beneficios(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.registra_logs_fornecimento_doacao_beneficios() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, OLD::TEXT, NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', OLD::TEXT, TG_TABLE_NAME, NULL);
        RETURN OLD;
    END IF;
END;
$$;


ALTER FUNCTION public.registra_logs_fornecimento_doacao_beneficios() OWNER TO postgres;

--
-- TOC entry 255 (class 1255 OID 124277)
-- Name: registra_logs_movimentacoes_estoque_beneficios(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.registra_logs_movimentacoes_estoque_beneficios() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, OLD::TEXT, NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', OLD::TEXT, TG_TABLE_NAME, NULL);
        RETURN OLD;
    END IF;
END;
$$;


ALTER FUNCTION public.registra_logs_movimentacoes_estoque_beneficios() OWNER TO postgres;

--
-- TOC entry 250 (class 1255 OID 124144)
-- Name: registra_logs_tipo_aquisicao(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.registra_logs_tipo_aquisicao() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, OLD::TEXT, NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', OLD::TEXT, TG_TABLE_NAME, NULL);
        RETURN OLD;
    END IF;
END;
$$;


ALTER FUNCTION public.registra_logs_tipo_aquisicao() OWNER TO postgres;

--
-- TOC entry 252 (class 1255 OID 124199)
-- Name: registra_logs_tipo_beneficio(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.registra_logs_tipo_beneficio() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'UPDATE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, OLD::TEXT, NEW::TEXT, TG_TABLE_NAME, NULL); 
        RETURN NEW;
    ELSIF TG_OP = 'DELETE' THEN
        INSERT INTO log_system(operacao, valores_velhos, valores_novos, nome_tabela_log, id_usuario_logado) 
		VALUES(TG_OP, '', OLD::TEXT, TG_TABLE_NAME, NULL);
        RETURN OLD;
    END IF;
END;
$$;


ALTER FUNCTION public.registra_logs_tipo_beneficio() OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 207 (class 1259 OID 123839)
-- Name: beneficiarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.beneficiarios (
    id_beneficiario integer NOT NULL,
    cpf_beneficiario character varying(11) NOT NULL,
    primeiro_nome_beneficiario character varying(35) NOT NULL,
    ultimo_nome_beneficiario character varying(35) NOT NULL,
    nis_beneficiario character varying(11) NOT NULL,
    celular_beneficiario_required character varying(11) NOT NULL,
    celular_beneficiario_opcional character varying(11),
    endereco_beneficiario character varying(150) NOT NULL,
    bairro_beneficiario character varying(50) NOT NULL,
    cidade_beneficiario character varying(50) NOT NULL,
    uf_beneficiario character(2) NOT NULL,
    qtd_pessoas_resid_beneficiario integer NOT NULL,
    renda_per_capita_beneficiario money NOT NULL,
    observacao_beneficiario text,
    fk_usuario integer,
    email_benef character varying(70),
    cep_benef character varying(10),
    complemento_ende_benef text,
    abrangencia_cras_benef character varying(30),
    data_hora timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.beneficiarios OWNER TO postgres;

--
-- TOC entry 206 (class 1259 OID 123837)
-- Name: beneficiarios_id_beneficiario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.beneficiarios_id_beneficiario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.beneficiarios_id_beneficiario_seq OWNER TO postgres;

--
-- TOC entry 3057 (class 0 OID 0)
-- Dependencies: 206
-- Name: beneficiarios_id_beneficiario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.beneficiarios_id_beneficiario_seq OWNED BY public.beneficiarios.id_beneficiario;


--
-- TOC entry 230 (class 1259 OID 124242)
-- Name: beneficio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.beneficio (
    id_beneficio integer NOT NULL,
    descricao character varying(300),
    id_tipo_beneficio integer NOT NULL,
    id_fornecedor_doador integer NOT NULL,
    quantidade integer NOT NULL,
    data_hora timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.beneficio OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 124240)
-- Name: beneficio_id_beneficio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.beneficio_id_beneficio_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.beneficio_id_beneficio_seq OWNER TO postgres;

--
-- TOC entry 3058 (class 0 OID 0)
-- Dependencies: 229
-- Name: beneficio_id_beneficio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.beneficio_id_beneficio_seq OWNED BY public.beneficio.id_beneficio;


--
-- TOC entry 215 (class 1259 OID 123924)
-- Name: categoria_beneficios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categoria_beneficios (
    id_categoria integer NOT NULL,
    nome character varying(40) NOT NULL,
    descricao character varying(300) NOT NULL,
    data_hora timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.categoria_beneficios OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 123922)
-- Name: categoria_beneficios_id_categoria_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categoria_beneficios_id_categoria_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categoria_beneficios_id_categoria_seq OWNER TO postgres;

--
-- TOC entry 3059 (class 0 OID 0)
-- Dependencies: 214
-- Name: categoria_beneficios_id_categoria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categoria_beneficios_id_categoria_seq OWNED BY public.categoria_beneficios.id_categoria;


--
-- TOC entry 226 (class 1259 OID 124203)
-- Name: entregas_beneficios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.entregas_beneficios (
    id_entrega_beneficio integer NOT NULL,
    data_entrega timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    id_beneficiario integer NOT NULL,
    id_tipo_beneficio integer NOT NULL,
    quantidade_entregue integer NOT NULL,
    id_usuario_responsavel_entrega integer NOT NULL
);


ALTER TABLE public.entregas_beneficios OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 124201)
-- Name: entregas_beneficios_id_entrega_beneficio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.entregas_beneficios_id_entrega_beneficio_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.entregas_beneficios_id_entrega_beneficio_seq OWNER TO postgres;

--
-- TOC entry 3060 (class 0 OID 0)
-- Dependencies: 225
-- Name: entregas_beneficios_id_entrega_beneficio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.entregas_beneficios_id_entrega_beneficio_seq OWNED BY public.entregas_beneficios.id_entrega_beneficio;


--
-- TOC entry 211 (class 1259 OID 123889)
-- Name: fornecedores_doadores; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fornecedores_doadores (
    id integer NOT NULL,
    nome character varying(70) NOT NULL,
    descricao character varying(300),
    identificacao text NOT NULL,
    tipo_pessoa text NOT NULL,
    cep character varying(10),
    endereco character varying(70) NOT NULL,
    complemento character varying(30),
    bairro character varying(50) NOT NULL,
    cidade character varying(150) NOT NULL,
    uf character(2) NOT NULL,
    telefone_celular character varying(15) NOT NULL,
    telefone_fixo character varying(14) NOT NULL,
    data_hora timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    cpf character varying(11),
    cnpj character varying(14),
    email character varying(70) NOT NULL,
    CONSTRAINT fornecedores_doadores_identificacao_check CHECK (((identificacao = 'DOADOR'::text) OR (identificacao = 'FORNECEDOR'::text))),
    CONSTRAINT fornecedores_doadores_tipo_pessoa_check CHECK (((tipo_pessoa = 'FISICA'::text) OR (tipo_pessoa = 'JURIDICA'::text)))
);


ALTER TABLE public.fornecedores_doadores OWNER TO postgres;

--
-- TOC entry 210 (class 1259 OID 123887)
-- Name: fornecedores_doadores_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.fornecedores_doadores_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.fornecedores_doadores_id_seq OWNER TO postgres;

--
-- TOC entry 3061 (class 0 OID 0)
-- Dependencies: 210
-- Name: fornecedores_doadores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.fornecedores_doadores_id_seq OWNED BY public.fornecedores_doadores.id;


--
-- TOC entry 222 (class 1259 OID 124148)
-- Name: fornecimento_doacao_beneficio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fornecimento_doacao_beneficio (
    id_fornecimento_doacao_beneficio integer NOT NULL,
    id_fornecedores_doadores integer NOT NULL,
    id_tipo_aquisicao integer NOT NULL,
    data_hora timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.fornecimento_doacao_beneficio OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 124146)
-- Name: fornecimento_doacao_beneficio_id_fornecimento_doacao_benefi_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.fornecimento_doacao_beneficio_id_fornecimento_doacao_benefi_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.fornecimento_doacao_beneficio_id_fornecimento_doacao_benefi_seq OWNER TO postgres;

--
-- TOC entry 3062 (class 0 OID 0)
-- Dependencies: 221
-- Name: fornecimento_doacao_beneficio_id_fornecimento_doacao_benefi_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.fornecimento_doacao_beneficio_id_fornecimento_doacao_benefi_seq OWNED BY public.fornecimento_doacao_beneficio.id_fornecimento_doacao_beneficio;


--
-- TOC entry 209 (class 1259 OID 123863)
-- Name: log_beneficiarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.log_beneficiarios (
    id_log integer NOT NULL,
    operacao character varying(10),
    valores_novos text,
    valores_velhos text,
    id_beneficiario integer,
    id_usuario integer,
    data_log timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.log_beneficiarios OWNER TO postgres;

--
-- TOC entry 208 (class 1259 OID 123861)
-- Name: log_beneficiarios_id_log_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.log_beneficiarios_id_log_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_beneficiarios_id_log_seq OWNER TO postgres;

--
-- TOC entry 3063 (class 0 OID 0)
-- Dependencies: 208
-- Name: log_beneficiarios_id_log_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.log_beneficiarios_id_log_seq OWNED BY public.log_beneficiarios.id_log;


--
-- TOC entry 213 (class 1259 OID 123909)
-- Name: log_fornecedores_doadores; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.log_fornecedores_doadores (
    id_log integer NOT NULL,
    operacao character varying(10),
    valores_novos text,
    valores_velhos text,
    id_fornecedor_doador integer,
    data_log timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.log_fornecedores_doadores OWNER TO postgres;

--
-- TOC entry 212 (class 1259 OID 123907)
-- Name: log_fornecedores_doadores_id_log_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.log_fornecedores_doadores_id_log_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_fornecedores_doadores_id_log_seq OWNER TO postgres;

--
-- TOC entry 3064 (class 0 OID 0)
-- Dependencies: 212
-- Name: log_fornecedores_doadores_id_log_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.log_fornecedores_doadores_id_log_seq OWNED BY public.log_fornecedores_doadores.id_log;


--
-- TOC entry 228 (class 1259 OID 124229)
-- Name: log_system; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.log_system (
    id_log integer NOT NULL,
    operacao character varying(10) NOT NULL,
    valores_velhos text NOT NULL,
    valores_novos text NOT NULL,
    nome_tabela_log text NOT NULL,
    data_hora_log timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    id_usuario_logado integer,
    CONSTRAINT log_system_operacao_check CHECK ((((operacao)::text = 'INSERT'::text) OR ((operacao)::text = 'DELETE'::text) OR ((operacao)::text = 'UPDATE'::text)))
);


ALTER TABLE public.log_system OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 124227)
-- Name: log_system_id_log_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.log_system_id_log_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_system_id_log_seq OWNER TO postgres;

--
-- TOC entry 3065 (class 0 OID 0)
-- Dependencies: 227
-- Name: log_system_id_log_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.log_system_id_log_seq OWNED BY public.log_system.id_log;


--
-- TOC entry 205 (class 1259 OID 123731)
-- Name: log_usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.log_usuarios (
    id_log integer NOT NULL,
    operacao character varying(10),
    valores_novos text,
    valores_velhos text,
    usuario integer NOT NULL,
    data_log timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.log_usuarios OWNER TO postgres;

--
-- TOC entry 204 (class 1259 OID 123729)
-- Name: log_usuarios_id_log_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.log_usuarios_id_log_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_usuarios_id_log_seq OWNER TO postgres;

--
-- TOC entry 3066 (class 0 OID 0)
-- Dependencies: 204
-- Name: log_usuarios_id_log_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.log_usuarios_id_log_seq OWNED BY public.log_usuarios.id_log;


--
-- TOC entry 232 (class 1259 OID 124263)
-- Name: movimentacoes_estoque_beneficios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.movimentacoes_estoque_beneficios (
    id_movimentacoes_estoque_beneficio integer NOT NULL,
    id_tipo_beneficio integer NOT NULL,
    tipo_movimentacao integer NOT NULL,
    quantidade_mov integer NOT NULL,
    data_hora_mov timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    descricao character varying(300),
    CONSTRAINT movimentacoes_estoque_beneficios_tipo_movimentacao_check CHECK (((tipo_movimentacao = 1) OR (tipo_movimentacao = 0)))
);


ALTER TABLE public.movimentacoes_estoque_beneficios OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 124261)
-- Name: movimentacoes_estoque_benefic_id_movimentacoes_estoque_bene_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.movimentacoes_estoque_benefic_id_movimentacoes_estoque_bene_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.movimentacoes_estoque_benefic_id_movimentacoes_estoque_bene_seq OWNER TO postgres;

--
-- TOC entry 3067 (class 0 OID 0)
-- Dependencies: 231
-- Name: movimentacoes_estoque_benefic_id_movimentacoes_estoque_bene_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.movimentacoes_estoque_benefic_id_movimentacoes_estoque_bene_seq OWNED BY public.movimentacoes_estoque_beneficios.id_movimentacoes_estoque_beneficio;


--
-- TOC entry 218 (class 1259 OID 124088)
-- Name: teste; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.teste AS
 SELECT (1 + 2);


ALTER TABLE public.teste OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 124119)
-- Name: tipo_aquisicao; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_aquisicao (
    id_tipo_aquisicao integer NOT NULL,
    tipo character varying(100) NOT NULL
);


ALTER TABLE public.tipo_aquisicao OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 124117)
-- Name: tipo_aquisicao_id_tipo_aquisicao_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_aquisicao_id_tipo_aquisicao_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_aquisicao_id_tipo_aquisicao_seq OWNER TO postgres;

--
-- TOC entry 3068 (class 0 OID 0)
-- Dependencies: 219
-- Name: tipo_aquisicao_id_tipo_aquisicao_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tipo_aquisicao_id_tipo_aquisicao_seq OWNED BY public.tipo_aquisicao.id_tipo_aquisicao;


--
-- TOC entry 224 (class 1259 OID 124180)
-- Name: tipo_beneficio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_beneficio (
    id_tipo_beneficio integer NOT NULL,
    nome_tipo character varying(150) NOT NULL,
    id_unidade_medida integer NOT NULL,
    id_categoria integer NOT NULL,
    data_hora timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.tipo_beneficio OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 124178)
-- Name: tipo_beneficio_id_tipo_beneficio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_beneficio_id_tipo_beneficio_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_beneficio_id_tipo_beneficio_seq OWNER TO postgres;

--
-- TOC entry 3069 (class 0 OID 0)
-- Dependencies: 223
-- Name: tipo_beneficio_id_tipo_beneficio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tipo_beneficio_id_tipo_beneficio_seq OWNED BY public.tipo_beneficio.id_tipo_beneficio;


--
-- TOC entry 217 (class 1259 OID 123933)
-- Name: unidades_medidas_beneficios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.unidades_medidas_beneficios (
    id_unidade integer NOT NULL,
    sigla character(2) NOT NULL,
    descricao character varying(50) NOT NULL,
    data_hora timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.unidades_medidas_beneficios OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 123931)
-- Name: unidades_medidas_beneficios_id_unidade_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.unidades_medidas_beneficios_id_unidade_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.unidades_medidas_beneficios_id_unidade_seq OWNER TO postgres;

--
-- TOC entry 3070 (class 0 OID 0)
-- Dependencies: 216
-- Name: unidades_medidas_beneficios_id_unidade_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.unidades_medidas_beneficios_id_unidade_seq OWNED BY public.unidades_medidas_beneficios.id_unidade;


--
-- TOC entry 203 (class 1259 OID 115425)
-- Name: usuario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuario (
    id_usuario integer NOT NULL,
    cpf_usuario character varying(14) NOT NULL,
    celular_usuario character varying(15) NOT NULL,
    email_usuario character varying(70) NOT NULL,
    cargo_usuario character varying(100) NOT NULL,
    tipo_usuario character varying(50) NOT NULL,
    senha_usuario character varying(32) NOT NULL,
    data_cadastro_usuario date DEFAULT CURRENT_DATE NOT NULL,
    nome_usuario character varying(70) NOT NULL
);


ALTER TABLE public.usuario OWNER TO postgres;

--
-- TOC entry 202 (class 1259 OID 115423)
-- Name: usuario_id_usuario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuario_id_usuario_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_id_usuario_seq OWNER TO postgres;

--
-- TOC entry 3071 (class 0 OID 0)
-- Dependencies: 202
-- Name: usuario_id_usuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuario_id_usuario_seq OWNED BY public.usuario.id_usuario;


--
-- TOC entry 2796 (class 2604 OID 123842)
-- Name: beneficiarios id_beneficiario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.beneficiarios ALTER COLUMN id_beneficiario SET DEFAULT nextval('public.beneficiarios_id_beneficiario_seq'::regclass);


--
-- TOC entry 2820 (class 2604 OID 124245)
-- Name: beneficio id_beneficio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.beneficio ALTER COLUMN id_beneficio SET DEFAULT nextval('public.beneficio_id_beneficio_seq'::regclass);


--
-- TOC entry 2806 (class 2604 OID 123927)
-- Name: categoria_beneficios id_categoria; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria_beneficios ALTER COLUMN id_categoria SET DEFAULT nextval('public.categoria_beneficios_id_categoria_seq'::regclass);


--
-- TOC entry 2815 (class 2604 OID 124206)
-- Name: entregas_beneficios id_entrega_beneficio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entregas_beneficios ALTER COLUMN id_entrega_beneficio SET DEFAULT nextval('public.entregas_beneficios_id_entrega_beneficio_seq'::regclass);


--
-- TOC entry 2800 (class 2604 OID 123892)
-- Name: fornecedores_doadores id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fornecedores_doadores ALTER COLUMN id SET DEFAULT nextval('public.fornecedores_doadores_id_seq'::regclass);


--
-- TOC entry 2811 (class 2604 OID 124151)
-- Name: fornecimento_doacao_beneficio id_fornecimento_doacao_beneficio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fornecimento_doacao_beneficio ALTER COLUMN id_fornecimento_doacao_beneficio SET DEFAULT nextval('public.fornecimento_doacao_beneficio_id_fornecimento_doacao_benefi_seq'::regclass);


--
-- TOC entry 2798 (class 2604 OID 123866)
-- Name: log_beneficiarios id_log; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_beneficiarios ALTER COLUMN id_log SET DEFAULT nextval('public.log_beneficiarios_id_log_seq'::regclass);


--
-- TOC entry 2804 (class 2604 OID 123912)
-- Name: log_fornecedores_doadores id_log; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_fornecedores_doadores ALTER COLUMN id_log SET DEFAULT nextval('public.log_fornecedores_doadores_id_log_seq'::regclass);


--
-- TOC entry 2817 (class 2604 OID 124232)
-- Name: log_system id_log; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_system ALTER COLUMN id_log SET DEFAULT nextval('public.log_system_id_log_seq'::regclass);


--
-- TOC entry 2794 (class 2604 OID 123734)
-- Name: log_usuarios id_log; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_usuarios ALTER COLUMN id_log SET DEFAULT nextval('public.log_usuarios_id_log_seq'::regclass);


--
-- TOC entry 2822 (class 2604 OID 124266)
-- Name: movimentacoes_estoque_beneficios id_movimentacoes_estoque_beneficio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movimentacoes_estoque_beneficios ALTER COLUMN id_movimentacoes_estoque_beneficio SET DEFAULT nextval('public.movimentacoes_estoque_benefic_id_movimentacoes_estoque_bene_seq'::regclass);


--
-- TOC entry 2810 (class 2604 OID 124122)
-- Name: tipo_aquisicao id_tipo_aquisicao; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_aquisicao ALTER COLUMN id_tipo_aquisicao SET DEFAULT nextval('public.tipo_aquisicao_id_tipo_aquisicao_seq'::regclass);


--
-- TOC entry 2813 (class 2604 OID 124183)
-- Name: tipo_beneficio id_tipo_beneficio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_beneficio ALTER COLUMN id_tipo_beneficio SET DEFAULT nextval('public.tipo_beneficio_id_tipo_beneficio_seq'::regclass);


--
-- TOC entry 2808 (class 2604 OID 123936)
-- Name: unidades_medidas_beneficios id_unidade; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.unidades_medidas_beneficios ALTER COLUMN id_unidade SET DEFAULT nextval('public.unidades_medidas_beneficios_id_unidade_seq'::regclass);


--
-- TOC entry 2792 (class 2604 OID 115428)
-- Name: usuario id_usuario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario ALTER COLUMN id_usuario SET DEFAULT nextval('public.usuario_id_usuario_seq'::regclass);


--
-- TOC entry 3027 (class 0 OID 123839)
-- Dependencies: 207
-- Data for Name: beneficiarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.beneficiarios (id_beneficiario, cpf_beneficiario, primeiro_nome_beneficiario, ultimo_nome_beneficiario, nis_beneficiario, celular_beneficiario_required, celular_beneficiario_opcional, endereco_beneficiario, bairro_beneficiario, cidade_beneficiario, uf_beneficiario, qtd_pessoas_resid_beneficiario, renda_per_capita_beneficiario, observacao_beneficiario, fk_usuario, email_benef, cep_benef, complemento_ende_benef, abrangencia_cras_benef, data_hora) FROM stdin;
10	78918283738	Cecilia Meireles	Almeida	91828373810	61989897676	61981345678	Rua Lindolfo Gonçalves	Centro	Formosa	GO	2	R$ 890,23	beneficiário, necessita de benefícios alimentícios e precisa de atendimentos de psicólogas	37	cecilia_res@gmail.com	73801030	\N	cras1	2021-11-23 09:58:12.742304
19	12393801920	Paulo Ricardo	Rocha	00019201209	61999999999	613643-689	Rua Lindolfo Gonçalves	Centro	Formosa	GO	2	R$ 35.455,00	teste descrição	37	paulo@uol.com	73801030	\N	cras2	2021-12-11 15:39:10.430932
\.


--
-- TOC entry 3049 (class 0 OID 124242)
-- Dependencies: 230
-- Data for Name: beneficio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.beneficio (id_beneficio, descricao, id_tipo_beneficio, id_fornecedor_doador, quantidade, data_hora) FROM stdin;
6	teste descrição insert 1	1	10	5	2021-12-08 10:46:44.901729
7	teste descricao	24	11	5	2021-12-08 10:52:14.70026
8		29	12	30	2021-12-08 10:55:36.808373
9		26	13	4	2021-12-08 10:55:37.069027
10		31	14	5	2021-12-08 10:58:35.8705
11		29	15	15	2021-12-08 14:08:10.903658
12		29	16	5	2021-12-08 14:08:11.479822
15	teste insert entrada	29	19	51	2021-12-09 10:11:29.577406
16	teste de descrição	25	20	10	2021-12-10 09:38:16.475903
17	teste	17	21	11	2021-12-10 09:45:01.487642
18	teste y	23	22	1	2021-12-10 10:14:00.589541
19	teste p	19	24	5	2021-12-10 10:15:43.771237
20	teste de insert	9	25	150	2021-12-10 10:15:44.009349
21	testando o refatoramento	20	26	15	2021-12-10 10:19:15.122603
22	asdasdasdsad	1	27	10	2021-12-15 19:37:31.25418
23	Teste de cadastro de beneficio	1	28	5	2022-02-07 15:19:02.177015
\.


--
-- TOC entry 3035 (class 0 OID 123924)
-- Dependencies: 215
-- Data for Name: categoria_beneficios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categoria_beneficios (id_categoria, nome, descricao, data_hora) FROM stdin;
3	Saude	categoria para beneficios como remédios, equipamentos medicos, e equipamentos ortopédicos	2021-11-05 21:27:13.143309
5	Nova Categoria	teste de descrição de categoria	2021-11-06 13:59:08.017174
1	Entreterimento	categoria que agrega brinquedos e outras objetos que ajudam a entreter crianças.	2021-11-05 21:21:52.082148
7	Alimenticia	categoria que abrange alimentos e cestas basicas, verdutas, frutas	2021-11-11 10:56:55.670648
8	Vestimenta	categoria que abrange roupas, masculinas e femininas de todas as idades	2021-11-24 09:52:53.443704
\.


--
-- TOC entry 3045 (class 0 OID 124203)
-- Dependencies: 226
-- Data for Name: entregas_beneficios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.entregas_beneficios (id_entrega_beneficio, data_entrega, id_beneficiario, id_tipo_beneficio, quantidade_entregue, id_usuario_responsavel_entrega) FROM stdin;
1	2021-12-13 10:42:23.996149	10	1	2	10
2	2021-12-13 10:59:32.296508	19	17	5	19
3	2021-12-13 10:59:32.605908	19	31	3	19
4	2021-12-13 11:12:08.076025	10	20	13	10
5	2021-12-15 18:57:27.574545	10	1	1	37
6	2021-12-15 19:42:02.201879	10	1	1	37
\.


--
-- TOC entry 3031 (class 0 OID 123889)
-- Dependencies: 211
-- Data for Name: fornecedores_doadores; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.fornecedores_doadores (id, nome, descricao, identificacao, tipo_pessoa, cep, endereco, complemento, bairro, cidade, uf, telefone_celular, telefone_fixo, data_hora, cpf, cnpj, email) FROM stdin;
22	TEM SUPERMERCADOS SETOR SUL LIMITDA	fornecedor de alimentos, com mercadorias avulsas conforme necessidade.	FORNECEDOR	JURIDICA	73802489	Avenida Tancredo Neves	\N	Setor Sul	Formosa	GO	61998605070	6136425070	2021-11-02 09:25:28.98667	\N	26848415000103	thiago@temsupermercados.com.br
3	Sacolão do Ciee	fornecedor de verduras e frutas frescas	FORNECEDOR	JURIDICA	73813401	Rua São Benedito	\N	Formosinha	Formosa	GO	61992345678	6136312315	2021-10-26 11:03:17.507505	\N	11468286000150	sacolaociee@gmail.com
23	Atacadão da cesta básica	fornecedor de cesta básica em todo DF e entorno, fornece cestas de diversos tipos e variedades.	FORNECEDOR	JURIDICA	\N	Quadra 5 Lote 16	galpão	Taguatinga norte	Brasilia	DF	61999111212	6133521558	2021-11-22 20:03:18.452986	\N	12678756000173	contato@atacadaocestabasica.com.br
24	Atacadão da Roupa	doador de roupas, diretamente da fabrica.	DOADOR	JURIDICA	55195009	Rua Joaquim Nabuco	(Lot Sta Tereza)	Cruz Alta	Santa Cruz do Capibaribe	PE	81981888363	8140420174	2021-11-24 09:56:53.042621	\N	17747088000102	sac@atacadaodaroupa.com
20	Sacolão preço bom	fornecedores e doador de frutas e verduras.	FORNECEDOR	JURIDICA	73802035	Rua 28	prédio verde, no térreo	Setor Bosque	Formosa	GO	61998213456	6136424991	2021-11-02 09:13:25.230101	\N	11078272000120	precisao.contabilidade@hotmail.com
19	Karoline Marques Nogueira	doadora de brinquedos masculinos.	DOADOR	FISICA	73801030	Rua Lindolfo Gonçalves	\N	Centro	Formosa	GO	61928281910	6192902191	2021-11-01 22:06:26.376496	90184392391	\N	carol_sizele@gov.com
\.


--
-- TOC entry 3041 (class 0 OID 124148)
-- Dependencies: 222
-- Data for Name: fornecimento_doacao_beneficio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.fornecimento_doacao_beneficio (id_fornecimento_doacao_beneficio, id_fornecedores_doadores, id_tipo_aquisicao, data_hora) FROM stdin;
10	23	4	2021-12-08 10:46:44.961132
11	24	3	2021-12-08 10:52:14.862134
12	20	3	2021-12-08 10:55:36.87445
13	22	5	2021-12-08 10:55:37.127531
14	20	3	2021-12-08 10:58:36.034613
15	3	4	2021-12-08 14:08:11.059747
16	3	4	2021-12-08 14:08:11.529355
17	23	4	2021-12-09 10:03:44.813343
18	23	4	2021-12-09 10:06:51.616895
19	20	3	2021-12-09 10:11:29.635698
20	20	4	2021-12-10 09:38:16.562983
21	24	5	2021-12-10 09:45:01.539868
22	22	1	2021-12-10 10:14:00.655703
24	22	4	2021-12-10 10:15:43.830905
25	22	4	2021-12-10 10:15:44.061969
26	24	5	2021-12-10 10:19:15.289371
27	23	3	2021-12-15 19:37:31.318816
28	23	1	2022-02-07 15:19:02.268034
\.


--
-- TOC entry 3029 (class 0 OID 123863)
-- Dependencies: 209
-- Data for Name: log_beneficiarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.log_beneficiarios (id_log, operacao, valores_novos, valores_velhos, id_beneficiario, id_usuario, data_log) FROM stdin;
1	INSERT	(1,02233322211,"Rosa Maria",Deus,11122266690,61990901212,,"Rua olimpio jacinto",centro,Formosa,GO,2,3.560,,25,,,casa,"cras 2")		1	25	2021-10-10 14:03:01.787825
2	INSERT	(2,01133322211,"Rosa Maria",Deus,22222266690,61990901212,,"Rua olimpio jacinto",centro,Formosa,GO,2,3.560,,25,,,casa,"cras 2")		2	25	2021-10-10 14:03:44.661778
3	UPDATE	(2,01133322211,Çalune,Oliveira,22222266690,61990901212,,"Rua olimpio jacinto",centro,Formosa,GO,2,3.560,,19,,,casa,"cras 2")	(2,01133322211,"Rosa Maria",Deus,22222266690,61990901212,,"Rua olimpio jacinto",centro,Formosa,GO,2,3.560,,25,,,casa,"cras 2")	2	19	2021-10-10 14:06:28.722377
4	UPDATE	(1,02233322211,"Gurcilina Nunes",Oliveira,11122266690,61990901212,,"Rua olimpio jacinto",centro,Formosa,GO,2,3.560,,21,,,casa,"cras 2")	(1,02233322211,"Rosa Maria",Deus,11122266690,61990901212,,"Rua olimpio jacinto",centro,Formosa,GO,2,3.560,,25,,,casa,"cras 2")	1	21	2021-10-10 14:07:43.893284
5	UPDATE	(2,01133322211,"Nova usuaria",teste,22222266690,61990901212,,"Rua olimpio jacinto",centro,Formosa,GO,2,3.560,,30,,,casa,"cras 2")	(2,01133322211,Çalune,Oliveira,22222266690,61990901212,,"Rua olimpio jacinto",centro,Formosa,GO,2,3.560,,19,,,casa,"cras 2")	2	30	2021-10-10 14:08:12.766562
6	DELETE	(2,01133322211,"Nova usuaria",teste,22222266690,61990901212,,"Rua olimpio jacinto",centro,Formosa,GO,2,3.560,,30,,,casa,"cras 2")		\N	\N	2021-10-10 14:08:46.203654
7	UPDATE	(1,02233322211,"Gurcilina Nunes",Oliveira,11122266690,61990901212,,"Rua olimpio jacinto",centro,Formosa,GO,2,3.560,,,,,casa,"cras 2")	(1,02233322211,"Gurcilina Nunes",Oliveira,11122266690,61990901212,,"Rua olimpio jacinto",centro,Formosa,GO,2,3.560,,21,,,casa,"cras 2")	1	\N	2021-10-10 14:11:46.503107
8	INSERT	(3,91028128013,"Igor Guimarães","Boneco Josias",89121982981,61984373712,61983738383,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,983.45,,25,,73801030,,cras1)		3	25	2021-10-10 15:24:58.162757
9	INSERT	(4,89012345699,"Connor MC",Gregor,98172891010,61981213456,613631-879,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,4.567,"sem observação, não precisa de beneficio",25,conor_mma@ufc.com,73801030,,cras1)		4	25	2021-10-10 15:42:36.598966
10	INSERT	(5,45689101092,"Tiago Ventura",Comediante,79923474568,53998234567,533632-567,"Rua 1",Sepetiba,"Rio de Janeiro",RJ,2,3.56,"sem observação ",37,tiago_p@hotmail.com,23545037,"(Acesso Est Sepetiba 4718)",cras1)		5	37	2021-10-11 16:00:13.052459
11	INSERT	(6,89134567800,"Paulo Plinio","Paulinho o loko",99993333444,61789893434,61734345252,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,3,789.34,"sem observações, não precisa de benefícios",37,paulo@cidadealta.com,73801030,,cras1)		6	37	2021-10-15 11:16:48.989954
12	INSERT	(7,90134567890,"Miguel Anjel",Ramires,12345678900,77987879090,613631-989,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,3,567.89,,37,email@teste.com,73801030,,cras1)		7	37	2021-10-15 20:03:44.850577
13	INSERT	(8,12312412423," "," ",12312312312,12323213213,21321312323," "," "," ",pe,2,456.78,,37,,," ",cras1)		8	37	2021-10-16 14:18:46.220066
14	UPDATE	(8,12312412423," Maradona",Napoli,12312312312,12323213213,21321312323,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,456.78,,37,maradona@napoli.com,73801030,,cras1)	(8,12312412423," "," ",12312312312,12323213213,21321312323," "," "," ",pe,2,456.78,,37,,," ",cras1)	8	37	2021-10-16 16:48:05.808202
15	INSERT	(9,90189291010,"Jose Soares","Da Silva",23456789012,78994945690,61945678999,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,902.34,,37,jose_f@gmail.com,73801030,,cras1)		9	37	2021-10-17 13:12:14.953099
16	INSERT	(10,78918283738,"Cecilia Meireles",Almeida,91828373810,61989897676,61981345678,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,890.23,"beneficiário, necessita de benefícios alimentícios e precisa de atendimentos de psicólogas",37,cecilia_res@gmail.com,73801030,,cras1)		10	37	2021-10-17 13:58:23.987116
17	INSERT	(12,88332457181,"Luciano Do Valle",Narrador,12345678909,61981234567,61976234567,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,654.67,"sem obs",37,Luciano@gmail.com,73801030,,cras1)		12	37	2021-10-17 16:01:00.000103
18	UPDATE	(12,883245181,"Luciano Do Valle",Narrador,12345678909,61981234567,61976234567,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,654.67,,37,Luciano@gmail.com,73801030,casa,cras1)	(12,88332457181,"Luciano Do Valle",Narrador,12345678909,61981234567,61976234567,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,654.67,"sem obs",37,Luciano@gmail.com,73801030,,cras1)	12	37	2021-10-17 16:59:51.581415
19	UPDATE	(9,901929010,"Jose Soares","Da Silva",23456789012,78994945690,61945678999,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,902.34,,37,jose_f@gmail.com,73801030,"mora no prédio verde, bloco g, apartamento 90E",cras1)	(9,90189291010,"Jose Soares","Da Silva",23456789012,78994945690,61945678999,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,902.34,,37,jose_f@gmail.com,73801030,,cras1)	9	37	2021-10-18 08:13:51.101564
20	INSERT	(13,55599922234,"Vanderléa Soares",Silva,00011144455,53981345690,77982341456,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,1.255,"beneficiaria, não precisa de benefícios.",37,vand.123@gmail.com,23595180,"(Cj Cesarão)",cras1)		13	37	2021-10-18 08:21:42.412675
21	UPDATE	(13,555992234,"Vanderléa Soares",Silva,00011144455,53981345690,77982341456,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,12.55,,37,vand.123@gmail.com,23595180,"(Cj Cesarão)",cras1)	(13,55599922234,"Vanderléa Soares",Silva,00011144455,53981345690,77982341456,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,1.255,"beneficiaria, não precisa de benefícios.",37,vand.123@gmail.com,23595180,"(Cj Cesarão)",cras1)	13	37	2021-10-18 08:27:10.458122
22	INSERT	(14,67845623451,"Trajano Churt",Romeu,23456790012,61987675432,53942345678,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,"R$ 89,00",,37,trajano_fut@uol.com,23555240,"(Acesso Est do Zepelin)",cras1)		14	37	2021-10-18 08:46:00.830547
23	UPDATE	(14,678562451,"Trajano Churt",Romeu,23456790012,61987675432,53942345678,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,"R$ 8.923,00",,37,trajano_fut@uol.com,23555240,"(Acesso Est do Zepelin)",cras1)	(14,67845623451,"Trajano Churt",Romeu,23456790012,61987675432,53942345678,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,"R$ 89,00",,37,trajano_fut@uol.com,23555240,"(Acesso Est do Zepelin)",cras1)	14	37	2021-10-18 08:47:34.347015
24	DELETE	(6,89134567800,"Paulo Plinio","Paulinho o loko",99993333444,61789893434,61734345252,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,3,"R$ 789,34","sem observações, não precisa de benefícios",37,paulo@cidadealta.com,73801030,,cras1)		\N	\N	2021-10-18 10:01:26.635239
25	UPDATE	(1,022332211,"Gurcilina Nunes",Oliveira,11122266690,61990901212,53983452312,"Rua 12",Paciência,"Rio de Janeiro",RJ,2,"R$ 35.632,00",,37,nunes_32@gmail.com,23580450,"(Vl Alzira I)",cras1)	(1,02233322211,"Gurcilina Nunes",Oliveira,11122266690,61990901212,,"Rua olimpio jacinto",centro,Formosa,GO,2,"R$ 3,56",,,,,casa,"cras 2")	1	37	2021-10-18 10:06:03.358917
26	DELETE	(1,022332211,"Gurcilina Nunes",Oliveira,11122266690,61990901212,53983452312,"Rua 12",Paciência,"Rio de Janeiro",RJ,2,"R$ 35.632,00",,37,nunes_32@gmail.com,23580450,"(Vl Alzira I)",cras1)		\N	\N	2021-10-18 10:06:34.099342
27	UPDATE	(4,890234699,"Connor MC",Gregor,98172891010,61981213456,613631-879,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 45.799,00",,37,conor_mma@ufc.com,73801030,"casa 100, quadra 90",cras2)	(4,89012345699,"Connor MC",Gregor,98172891010,61981213456,613631-879,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 4,57","sem observação, não precisa de beneficio",25,conor_mma@ufc.com,73801030,,cras1)	4	37	2021-10-18 10:14:25.340521
28	DELETE	(4,890234699,"Connor MC",Gregor,98172891010,61981213456,613631-879,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 45.799,00",,37,conor_mma@ufc.com,73801030,"casa 100, quadra 90",cras2)		\N	\N	2021-10-18 10:15:20.620332
29	INSERT	(15,86736451172,"Mark Zukemberg",Facebook,23254525425,61984536767,53478191918,"Rua Alves de Castro",Centro,Formosa,GO,2,"R$ 4.567,00",,37,mark_34@facebook.com,73801140,,cras1)		15	37	2021-10-18 10:17:48.109652
30	INSERT	(16,91020302901,"Theylor Suifete",Hidden,12123243433,439817-728,619872-271,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 4.567,00",,37,,73801030,,cras1)		16	37	2021-10-18 10:37:18.630051
31	UPDATE	(16,910030901,"Theylor Suifete",Hidden,12123243433,439817-728,619872-271,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 4.567,00",,37,,73801030,,cras1)	(16,91020302901,"Theylor Suifete",Hidden,12123243433,439817-728,619872-271,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 4.567,00",,37,,73801030,,cras1)	16	37	2021-10-18 10:41:10.51845
32	INSERT	(17,98765432100,"Beneficiário Tetê","sem sobrenome",00066688821,53987673212,53981234578,"Rua Senador Borba",Centro,Formosa,GO,2,"R$ 5.978,00",,37,tete@uol.com,73801120,,cras1)		17	37	2021-10-18 10:49:15.095582
33	UPDATE	(17,987543100,"Beneficiário Tetê","sem sobrenome",00066688821,53987673212,53981234578,"Rua Senador Borba",Centro,Formosa,GO,2,"R$ 5.978,78",,37,tete@uol.com,73801120,,cras1)	(17,98765432100,"Beneficiário Tetê","sem sobrenome",00066688821,53987673212,53981234578,"Rua Senador Borba",Centro,Formosa,GO,2,"R$ 5.978,00",,37,tete@uol.com,73801120,,cras1)	17	37	2021-10-18 10:50:07.884454
34	DELETE	(12,883245181,"Luciano Do Valle",Narrador,12345678909,61981234567,61976234567,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 654,67",,37,Luciano@gmail.com,73801030,casa,cras1)		\N	\N	2021-10-18 10:51:08.921803
35	UPDATE	(3,910812013,"Igor Guimarães","Boneco Josias",89121982981,61984373712,61983738383,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 98.345,12",,37,igor_come@sbt.com,73801030,,cras1)	(3,91028128013,"Igor Guimarães","Boneco Josias",89121982981,61984373712,61983738383,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 983,45",,25,,73801030,,cras1)	3	37	2021-10-18 10:57:56.406717
36	DELETE	(3,910812013,"Igor Guimarães","Boneco Josias",89121982981,61984373712,61983738383,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 98.345,12",,37,igor_come@sbt.com,73801030,,cras1)		3	37	2021-10-18 10:58:13.415223
37	DELETE	(5,45689101092,"Tiago Ventura",Comediante,79923474568,53998234567,533632-567,"Rua 1",Sepetiba,"Rio de Janeiro",RJ,2,"R$ 3,56","sem observação ",37,tiago_p@hotmail.com,23545037,"(Acesso Est Sepetiba 4718)",cras1)		5	37	2021-10-18 11:21:56.618569
38	INSERT	(18,90189283019,"Casemiro Rodrigues",Seleção,00019201290,61945568918,61984738281,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 5.467,00",,37,casemiro@real.com,73801030,,cras1)		18	37	2021-10-18 20:04:29.628505
39	UPDATE	(18,901928019,"Casemiro Rodrigues",Seleção,00019201290,61945568918,61984738281,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 54,67",,37,casemiro@real.com,73801030,,cras1)	(18,90189283019,"Casemiro Rodrigues",Seleção,00019201290,61945568918,61984738281,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 5.467,00",,37,casemiro@real.com,73801030,,cras1)	18	37	2021-10-18 20:05:33.446021
40	DELETE	(18,901928019,"Casemiro Rodrigues",Seleção,00019201290,61945568918,61984738281,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 54,67",,37,casemiro@real.com,73801030,,cras1)		18	37	2021-10-18 20:08:10.96788
41	DELETE	(7,90134567890,"Miguel Anjel",Ramires,12345678900,77987879090,613631-989,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,3,"R$ 567,89",,37,email@teste.com,73801030,,cras1)		7	37	2021-10-18 20:11:31.070621
42	UPDATE	(8,123241423," Maradona Paulo",Napoli,12312312312,12323213213,21321312323,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 456,78",,37,maradona@napoli.com,73801030,,cras1)	(8,12312412423," Maradona",Napoli,12312312312,12323213213,21321312323,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 456,78",,37,maradona@napoli.com,73801030,,cras1)	8	37	2021-10-20 19:11:53.083349
43	DELETE	(8,123241423," Maradona Paulo",Napoli,12312312312,12323213213,21321312323,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 456,78",,37,maradona@napoli.com,73801030,,cras1)		8	37	2021-10-20 19:13:09.183664
44	UPDATE	(16,9103091,"Theylor Suifete",Hidden,12123243433,439817-728,619872-271,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 4.567,00",,37,,73801030,,cras1)	(16,910030901,"Theylor Suifete",Hidden,12123243433,439817-728,619872-271,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 4.567,00",,37,,73801030,,cras1)	16	37	2021-10-26 21:12:49.658139
45	UPDATE	(15,867645172,"Mark Zukemberg",Facebook,23254525425,61984536767,53478191918,"Rua Alves de Castro",Centro,Formosa,GO,2,"R$ 4.567,00",,37,mark_34@facebook.com,73801140,,cras1)	(15,86736451172,"Mark Zukemberg",Facebook,23254525425,61984536767,53478191918,"Rua Alves de Castro",Centro,Formosa,GO,2,"R$ 4.567,00",,37,mark_34@facebook.com,73801140,,cras1)	15	37	2021-10-30 14:55:37.113419
46	UPDATE	(15,8674512,"Mark Zukemberg",Facebook,23254525425,61984536767,53478191918,"Rua Alves de Castro",Centro,Formosa,GO,2,"R$ 400,00",,37,mark_34@facebook.com,73801140,,cras1)	(15,867645172,"Mark Zukemberg",Facebook,23254525425,61984536767,53478191918,"Rua Alves de Castro",Centro,Formosa,GO,2,"R$ 4.567,00",,37,mark_34@facebook.com,73801140,,cras1)	15	37	2021-10-31 13:42:01.429685
47	UPDATE	(10,78918283738,"Cecilia Meireles",Almeida,91828373810,61989897676,61981345678,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 890,23","beneficiário, necessita de benefícios alimentícios e precisa de atendimentos de psicólogas",37,cecilia_res@gmail.com,73801030,,cras1,"2021-11-23 09:58:12.742304")	(10,78918283738,"Cecilia Meireles",Almeida,91828373810,61989897676,61981345678,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 890,23","beneficiário, necessita de benefícios alimentícios e precisa de atendimentos de psicólogas",37,cecilia_res@gmail.com,73801030,,cras1,"2021-11-23 09:58:05.327712")	10	37	2021-11-23 09:58:12.742304
48	UPDATE	(9,901929010,"Jose Soares","Da Silva",23456789012,78994945690,61945678999,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 902,34",,37,jose_f@gmail.com,73801030,"mora no prédio verde, bloco g, apartamento 90E",cras1,"2021-11-23 09:58:12.742304")	(9,901929010,"Jose Soares","Da Silva",23456789012,78994945690,61945678999,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 902,34",,37,jose_f@gmail.com,73801030,"mora no prédio verde, bloco g, apartamento 90E",cras1,"2021-11-23 09:58:05.327712")	9	37	2021-11-23 09:58:12.742304
49	UPDATE	(13,555992234,"Vanderléa Soares",Silva,00011144455,53981345690,77982341456,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,"R$ 12,55",,37,vand.123@gmail.com,23595180,"(Cj Cesarão)",cras1,"2021-11-23 09:58:12.742304")	(13,555992234,"Vanderléa Soares",Silva,00011144455,53981345690,77982341456,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,"R$ 12,55",,37,vand.123@gmail.com,23595180,"(Cj Cesarão)",cras1,"2021-11-23 09:58:05.327712")	13	37	2021-11-23 09:58:12.742304
50	UPDATE	(14,678562451,"Trajano Churt",Romeu,23456790012,61987675432,53942345678,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,"R$ 8.923,00",,37,trajano_fut@uol.com,23555240,"(Acesso Est do Zepelin)",cras1,"2021-11-23 09:58:12.742304")	(14,678562451,"Trajano Churt",Romeu,23456790012,61987675432,53942345678,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,"R$ 8.923,00",,37,trajano_fut@uol.com,23555240,"(Acesso Est do Zepelin)",cras1,"2021-11-23 09:58:05.327712")	14	37	2021-11-23 09:58:12.742304
51	UPDATE	(17,987543100,"Beneficiário Tetê","sem sobrenome",00066688821,53987673212,53981234578,"Rua Senador Borba",Centro,Formosa,GO,2,"R$ 5.978,78",,37,tete@uol.com,73801120,,cras1,"2021-11-23 09:58:12.742304")	(17,987543100,"Beneficiário Tetê","sem sobrenome",00066688821,53987673212,53981234578,"Rua Senador Borba",Centro,Formosa,GO,2,"R$ 5.978,78",,37,tete@uol.com,73801120,,cras1,"2021-11-23 09:58:05.327712")	17	37	2021-11-23 09:58:12.742304
52	UPDATE	(16,9103091,"Theylor Suifete",Hidden,12123243433,439817-728,619872-271,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 4.567,00",,37,,73801030,,cras1,"2021-11-23 09:58:12.742304")	(16,9103091,"Theylor Suifete",Hidden,12123243433,439817-728,619872-271,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 4.567,00",,37,,73801030,,cras1,"2021-11-23 09:58:05.327712")	16	37	2021-11-23 09:58:12.742304
53	UPDATE	(15,8674512,"Mark Zukemberg",Facebook,23254525425,61984536767,53478191918,"Rua Alves de Castro",Centro,Formosa,GO,2,"R$ 400,00",,37,mark_34@facebook.com,73801140,,cras1,"2021-11-23 09:58:12.742304")	(15,8674512,"Mark Zukemberg",Facebook,23254525425,61984536767,53478191918,"Rua Alves de Castro",Centro,Formosa,GO,2,"R$ 400,00",,37,mark_34@facebook.com,73801140,,cras1,"2021-11-23 09:58:05.327712")	15	37	2021-11-23 09:58:12.742304
54	UPDATE	(13,5559224,"Vanderléa Soares",Silva,00011144455,53981345690,77982341456,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,"R$ 12,55","uma observação bem aqui",37,vand.123@gmail.com,23595180,"(Cj Cesarão)",cras1,"2021-11-23 09:58:12.742304")	(13,555992234,"Vanderléa Soares",Silva,00011144455,53981345690,77982341456,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,"R$ 12,55",,37,vand.123@gmail.com,23595180,"(Cj Cesarão)",cras1,"2021-11-23 09:58:12.742304")	13	37	2021-12-10 08:47:45.752719
55	INSERT	(19,12393801920,"Paulo Ricardo",Rocha,00019201209,61999999999,613643-689,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 35.455,00","teste descrição",37,paulo@uol.com,73801030,,cras2,"2021-12-11 15:39:10.430932")		19	37	2021-12-11 15:39:10.430932
56	DELETE	(13,5559224,"Vanderléa Soares",Silva,00011144455,53981345690,77982341456,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,"R$ 12,55","uma observação bem aqui",37,vand.123@gmail.com,23595180,"(Cj Cesarão)",cras1,"2021-11-23 09:58:12.742304")		13	37	2021-12-11 15:40:14.00466
57	DELETE	(15,8674512,"Mark Zukemberg",Facebook,23254525425,61984536767,53478191918,"Rua Alves de Castro",Centro,Formosa,GO,2,"R$ 400,00",,37,mark_34@facebook.com,73801140,,cras1,"2021-11-23 09:58:12.742304")		15	37	2021-12-11 15:40:34.685523
58	DELETE	(14,678562451,"Trajano Churt",Romeu,23456790012,61987675432,53942345678,"Rua 1","Santa Cruz","Rio de Janeiro",RJ,2,"R$ 8.923,00",,37,trajano_fut@uol.com,23555240,"(Acesso Est do Zepelin)",cras1,"2021-11-23 09:58:12.742304")		14	37	2021-12-11 15:40:50.769112
59	DELETE	(9,901929010,"Jose Soares","Da Silva",23456789012,78994945690,61945678999,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 902,34",,37,jose_f@gmail.com,73801030,"mora no prédio verde, bloco g, apartamento 90E",cras1,"2021-11-23 09:58:12.742304")		9	37	2021-12-11 15:40:58.235868
60	DELETE	(17,987543100,"Beneficiário Tetê","sem sobrenome",00066688821,53987673212,53981234578,"Rua Senador Borba",Centro,Formosa,GO,2,"R$ 5.978,78",,37,tete@uol.com,73801120,,cras1,"2021-11-23 09:58:12.742304")		17	37	2021-12-11 15:41:04.894248
61	DELETE	(16,9103091,"Theylor Suifete",Hidden,12123243433,439817-728,619872-271,"Rua Lindolfo Gonçalves",Centro,Formosa,GO,2,"R$ 4.567,00",,37,,73801030,,cras1,"2021-11-23 09:58:12.742304")		16	37	2021-12-11 15:41:10.374989
\.


--
-- TOC entry 3033 (class 0 OID 123909)
-- Dependencies: 213
-- Data for Name: log_fornecedores_doadores; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.log_fornecedores_doadores (id_log, operacao, valores_novos, valores_velhos, id_fornecedor_doador, data_log) FROM stdin;
1	INSERT	(2,"Sacolão ciee","Fornecedor de verduras frescass",FORNECEDOR,JURIDICA,73813401,"Rua Sao Benedito, 175","Loja de Esquina",Formosinha,Formosa,GO,61981782345,6136318757,"2021-10-25 15:02:50.302062",,26050839000128,ciee@gmail.com)		2	2021-10-25 15:02:50.302062
2	INSERT	(3,"Sacolão do Ciee","fornecedor de verduras e frutas frescas",FORNECEDOR,JURIDICA,73813401,"Rua São Benedito",,Formosinha,Formosa,GO,61992345678,6136312315,"2021-10-26 11:03:17.507505",,11468286000150,sacolaociee@gmail.com)		3	2021-10-26 11:03:17.507505
3	INSERT	(4,"Organizações Voluntarias De Goias","fornecedor de cesta básica de alimentos",FORNECEDOR,JURIDICA,74230130,"Avenida T 14",,"Setor Bueno",Goiânia,GO,61999999999,6232019400,"2021-10-26 11:11:23.818232",,02106664000165,suporte.voluntariado@ovg.org.br)		4	2021-10-26 11:11:23.818232
4	INSERT	(5,teste,undefined,DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,87128192819,8918291289,"2021-10-27 19:14:08.844292",12312312321,,teste@gmail.com)		5	2021-10-27 19:14:08.844292
5	INSERT	(6,"BSB Alimentos","fornecedor de cesta básica de alimentos",FORNECEDOR,JURIDICA,70833530,"CLN 203 Bloco C",,"Asa Norte",Brasília,DF,61990929091,6133284281,"2021-10-29 13:09:19.505917",,13692163000124,diskcontabil.legal@terra.com.br)		6	2021-10-29 13:09:19.505917
6	INSERT	(7,"João Lima Feitosa",undefined,DOADOR,FISICA,73816-899,"Área Rural",,"Área Rural de Formosa",Formosa,GO,61998764567,6136319090,"2021-10-29 13:13:50.758132",08711819290,,doador_joao@gmail.com)		7	2021-10-29 13:13:50.758132
7	INSERT	(8," Nutrycesta comércio de cestas básicas","fornecedor de cesta básica de alimentos",FORNECEDOR,JURIDICA,72140220,"QNJ 22",,"Taguatinga Norte (Taguatinga)",Brasília,DF,61992116537,6134915785,"2021-10-29 13:22:36.83626",,28926585000194,nutrycesta@gmail.com)		8	2021-10-29 13:22:36.83626
8	INSERT	(9,"Luis Vales Costa","doador de frutas frescas, fazendeiro",DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,61998765432,6136314578,"2021-10-30 08:38:54.500238",99911122233,,luis_faz@gmail.com)		9	2021-10-30 08:38:54.500238
9	INSERT	(10,"Sacolão Preço Bom","sacolão da cidade local, que forneçe verduras, e frutas frescas, conforme necessidade.",FORNECEDOR,JURIDICA,73802035,"Rua 28",,"Setor Bosque",Formosa,GO,61987675432,6136424991,"2021-10-30 16:07:35.864344",,11078272000120,precisao.contabilidade@hotmail.com)		10	2021-10-30 16:07:35.864344
10	UPDATE	(8," Nutrycesta comércio de cestas básicas","fornecedor de cesta básica de alimentos, e alimentos avulsos.",FORNECEDOR,JURIDICA,72140220,"QNJ 22",esquina,"Taguatinga Norte (Taguatinga)",Brasília,DF,61992116537,6134915785,"2021-10-29 13:22:36.83626",,28926585000194,nutrycesta@gmail.com)	(8," Nutrycesta comércio de cestas básicas","fornecedor de cesta básica de alimentos",FORNECEDOR,JURIDICA,72140220,"QNJ 22",,"Taguatinga Norte (Taguatinga)",Brasília,DF,61992116537,6134915785,"2021-10-29 13:22:36.83626",,28926585000194,nutrycesta@gmail.com)	8	2021-10-30 20:34:19.909914
11	UPDATE	(7,"João Lima Feitosa","doador, fazendeiro que faz doações.",DOADOR,FISICA,73816-899,"Área Rural",,"Área Rural de Formosa",Formosa,GO,61998764567,6136319090,"2021-10-29 13:13:50.758132",08711819290,,doador_joao@gmail.com)	(7,"João Lima Feitosa",undefined,DOADOR,FISICA,73816-899,"Área Rural",,"Área Rural de Formosa",Formosa,GO,61998764567,6136319090,"2021-10-29 13:13:50.758132",08711819290,,doador_joao@gmail.com)	7	2021-10-30 20:41:41.261203
12	INSERT	(11,"José Dirceu Alvares","doador de alfaces e tomates frescas.",DOADOR,FISICA,73801190,"Rua Jesulino Malheiros",,Centro,Formosa,GO,61983456790,6136317878,"2021-10-30 21:04:08.371198",09192031209,,josealves@gmail.com)		11	2021-10-30 21:04:08.371198
13	INSERT	(12,"Supermercado modelo","supermercado que fornece alimentos, para compor cestas aleatórias ",FORNECEDOR,JURIDICA,73802030,"Rua 27",,"Setor Bosque",Formosa,GO,61996959099,6134321108,"2021-10-30 21:14:14.285408",,16708540000164,supermercadomodelo525@yahoo.com)		12	2021-10-30 21:14:14.285408
14	UPDATE	(8," Nutrycesta comércio de cestas básicas","fornecedor de cesta básica de alimentos, e alimentos avulsos, para fornecer a promoção social, durante pandemia",FORNECEDOR,JURIDICA,72140220,"QNJ 22",esquina,"Taguatinga Norte (Taguatinga)",Brasília,DF,61992116537,6134915785,"2021-10-29 13:22:36.83626",,28926585000194,nutrycesta@gmail.com)	(8," Nutrycesta comércio de cestas básicas","fornecedor de cesta básica de alimentos, e alimentos avulsos.",FORNECEDOR,JURIDICA,72140220,"QNJ 22",esquina,"Taguatinga Norte (Taguatinga)",Brasília,DF,61992116537,6134915785,"2021-10-29 13:22:36.83626",,28926585000194,nutrycesta@gmail.com)	8	2021-10-30 21:24:51.338757
15	DELETE	(12,"Supermercado modelo","supermercado que fornece alimentos, para compor cestas aleatórias ",FORNECEDOR,JURIDICA,73802030,"Rua 27",,"Setor Bosque",Formosa,GO,61996959099,6134321108,"2021-10-30 21:14:14.285408",,16708540000164,supermercadomodelo525@yahoo.com)		12	2021-10-31 15:16:57.268422
16	DELETE	(11,"José Dirceu Alvares","doador de alfaces e tomates frescas.",DOADOR,FISICA,73801190,"Rua Jesulino Malheiros",,Centro,Formosa,GO,61983456790,6136317878,"2021-10-30 21:04:08.371198",09192031209,,josealves@gmail.com)		11	2021-10-31 15:20:27.644288
17	DELETE	(5,teste,undefined,DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,87128192819,8918291289,"2021-10-27 19:14:08.844292",12312312321,,teste@gmail.com)		5	2021-10-31 15:30:39.883207
18	DELETE	(9,"Luis Vales Costa","doador de frutas frescas, fazendeiro",DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,61998765432,6136314578,"2021-10-30 08:38:54.500238",99911122233,,luis_faz@gmail.com)		9	2021-10-31 15:31:09.417805
19	DELETE	(7,"João Lima Feitosa","doador, fazendeiro que faz doações.",DOADOR,FISICA,73816-899,"Área Rural",,"Área Rural de Formosa",Formosa,GO,61998764567,6136319090,"2021-10-29 13:13:50.758132",08711819290,,doador_joao@gmail.com)		7	2021-10-31 15:33:01.750074
20	DELETE	(8," Nutrycesta comércio de cestas básicas","fornecedor de cesta básica de alimentos, e alimentos avulsos, para fornecer a promoção social, durante pandemia",FORNECEDOR,JURIDICA,72140220,"QNJ 22",esquina,"Taguatinga Norte (Taguatinga)",Brasília,DF,61992116537,6134915785,"2021-10-29 13:22:36.83626",,28926585000194,nutrycesta@gmail.com)		8	2021-10-31 15:34:06.739988
21	DELETE	(10,"Sacolão Preço Bom","sacolão da cidade local, que forneçe verduras, e frutas frescas, conforme necessidade.",FORNECEDOR,JURIDICA,73802035,"Rua 28",,"Setor Bosque",Formosa,GO,61987675432,6136424991,"2021-10-30 16:07:35.864344",,11078272000120,precisao.contabilidade@hotmail.com)		10	2021-10-31 15:36:02.735982
22	INSERT	(13,asdasd,asdasd,DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,12312312321,1231231231,"2021-10-31 15:42:56.61184",12312312312,,teste@gmail.com)		13	2021-10-31 15:42:56.61184
23	DELETE	(13,asdasd,asdasd,DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,12312312321,1231231231,"2021-10-31 15:42:56.61184",12312312312,,teste@gmail.com)		13	2021-10-31 15:43:10.37656
24	UPDATE	(3,"Sacolão do Ciee","fornecedor de verduras e frutas frescas",FORNECEDOR,JURIDICA,73813401,"Rua São Benedito",,Formosinha,Formosa,GO,61992345678,6136312315,"2021-10-26 11:03:17.507505",,11468286000150,sacolaociee@gmail.com)	(3,"Sacolão do Ciee","fornecedor de verduras e frutas frescas",FORNECEDOR,JURIDICA,73813401,"Rua São Benedito",,Formosinha,Formosa,GO,61992345678,6136312315,"2021-10-26 11:03:17.507505",,11468286000150,sacolaociee@gmail.com)	3	2021-10-31 15:43:44.140277
25	UPDATE	(4,"Organizações Voluntarias De Goias","fornecedor de cesta básica de alimentos, próprio governo do estado de goiás",FORNECEDOR,JURIDICA,74230130,"Avenida T 14",,"Setor Bueno",Goiânia,GO,61999999999,6232019400,"2021-10-26 11:11:23.818232",,02106664000165,suporte.voluntariado@ovg.org.br)	(4,"Organizações Voluntarias De Goias","fornecedor de cesta básica de alimentos",FORNECEDOR,JURIDICA,74230130,"Avenida T 14",,"Setor Bueno",Goiânia,GO,61999999999,6232019400,"2021-10-26 11:11:23.818232",,02106664000165,suporte.voluntariado@ovg.org.br)	4	2021-10-31 15:44:22.930496
26	UPDATE	(2,"Sacolão ciee","Fornecedor de verduras frescas, e carnes.",FORNECEDOR,JURIDICA,73813401,"Rua Sao Benedito, 175","Loja de Esquina",Formosinha,Formosa,GO,61981782345,6136318757,"2021-10-25 15:02:50.302062",,26050839000128,ciee@gmail.com)	(2,"Sacolão ciee","Fornecedor de verduras frescass",FORNECEDOR,JURIDICA,73813401,"Rua Sao Benedito, 175","Loja de Esquina",Formosinha,Formosa,GO,61981782345,6136318757,"2021-10-25 15:02:50.302062",,26050839000128,ciee@gmail.com)	2	2021-10-31 15:46:57.492084
27	DELETE	(6,"BSB Alimentos","fornecedor de cesta básica de alimentos",FORNECEDOR,JURIDICA,70833530,"CLN 203 Bloco C",,"Asa Norte",Brasília,DF,61990929091,6133284281,"2021-10-29 13:09:19.505917",,13692163000124,diskcontabil.legal@terra.com.br)		6	2021-10-31 15:58:58.625544
28	INSERT	(14,asdasdasdasd,asdasdasdasds,FORNECEDOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,12312312312,1231232132,"2021-11-01 10:35:05.5178",12312312321,,teste@gmail.com)		14	2021-11-01 10:35:05.5178
29	DELETE	(14,asdasdasdasd,asdasdasdasds,FORNECEDOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,12312312312,1231232132,"2021-11-01 10:35:05.5178",12312312321,,teste@gmail.com)		14	2021-11-01 10:35:23.038742
30	INSERT	(15,saasas,asasas,DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,12412414141,1212312321,"2021-11-01 10:47:52.763569",12312312421,,teste@gmail.com)		15	2021-11-01 10:47:52.763569
31	DELETE	(15,saasas,asasas,DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,12412414141,1212312321,"2021-11-01 10:47:52.763569",12312312421,,teste@gmail.com)		15	2021-11-01 10:55:17.037023
32	INSERT	(16,paosdjapdo,aoisdnowen,DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,61727129189,1271872182,"2021-11-01 10:56:51.834733",90192012919,,teste@hotmail.com)		16	2021-11-01 10:56:51.834733
33	DELETE	(16,paosdjapdo,aoisdnowen,DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,61727129189,1271872182,"2021-11-01 10:56:51.834733",90192012919,,teste@hotmail.com)		16	2021-11-01 10:57:06.25535
34	INSERT	(17,qwqwqwdqw,qwdqwdwqdqw,FORNECEDOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,81829191910,7172812812,"2021-11-01 11:01:45.805349",81272811910,,teste@hotmail.com)		17	2021-11-01 11:01:45.805349
35	DELETE	(17,qwqwqwdqw,qwdqwdwqdqw,FORNECEDOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,81829191910,7172812812,"2021-11-01 11:01:45.805349",81272811910,,teste@hotmail.com)		17	2021-11-01 11:01:59.716661
36	DELETE	(2,"Sacolão ciee","Fornecedor de verduras frescas, e carnes.",FORNECEDOR,JURIDICA,73813401,"Rua Sao Benedito, 175","Loja de Esquina",Formosinha,Formosa,GO,61981782345,6136318757,"2021-10-25 15:02:50.302062",,26050839000128,ciee@gmail.com)		2	2021-11-01 11:04:10.281225
37	DELETE	(4,"Organizações Voluntarias De Goias","fornecedor de cesta básica de alimentos, próprio governo do estado de goiás",FORNECEDOR,JURIDICA,74230130,"Avenida T 14",,"Setor Bueno",Goiânia,GO,61999999999,6232019400,"2021-10-26 11:11:23.818232",,02106664000165,suporte.voluntariado@ovg.org.br)		4	2021-11-01 11:11:43.202867
38	INSERT	(18,"SACOLAO DO CIE","fornecedor de verduras e frutas frescas.",FORNECEDOR,JURIDICA,73813401,"Rua São Benedito",,Formosinha,Formosa,GO,61998123456,6136318757,"2021-11-01 11:20:35.814588",,26050839000128,ciee@yaoo.com)		18	2021-11-01 11:20:35.814588
39	DELETE	(18,"SACOLAO DO CIE","fornecedor de verduras e frutas frescas.",FORNECEDOR,JURIDICA,73813401,"Rua São Benedito",,Formosinha,Formosa,GO,61998123456,6136318757,"2021-11-01 11:20:35.814588",,26050839000128,ciee@yaoo.com)		18	2021-11-01 11:21:17.245879
40	INSERT	(19,"Karoline Marques","doadora de brinquedos masculinos.",DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,61928281910,6192902191,"2021-11-01 22:06:26.376496",90184392391,,carol_sizele@gov.com)		19	2021-11-01 22:06:26.376496
41	INSERT	(20,"Sacolão preço bom","fornecedores e doador de frutas e verduras.",FORNECEDOR,JURIDICA,73802035,"Rua 28",,"Setor Bosque",Formosa,GO,61998213456,6136424991,"2021-11-02 09:13:25.230101",,11078272000120,precisao.contabilidade@hotmail.com)		20	2021-11-02 09:13:25.230101
42	INSERT	(21,"Ideal Supermecado","Fornecedor de alimentos, e mercadorias.",FORNECEDOR,JURIDICA,73801040,"Rua Joaquim Honório Pereira Dutra",,Centro,Formosa,GO,61981237821,6136322552,"2021-11-02 09:20:24.506055",,00542552000202,idealsupernfe@gmail.com)		21	2021-11-02 09:20:24.506055
43	INSERT	(22,"TEM SUPERMERCADOS SETOR SUL LTDA","fornecedor de alimentos, com mercadorias avulsas conforme necessidade.",FORNECEDOR,JURIDICA,73802489,"Avenida Tancredo Neves",,"Setor Sul",Formosa,GO,61998605070,6136425070,"2021-11-02 09:25:28.98667",,26848415000103,thiago@temsupermercados.com.br)		22	2021-11-02 09:25:28.98667
44	UPDATE	(21,"Ideal Supermecado","Fornecedor de alimentos, e mercadorias.",FORNECEDOR,JURIDICA,73801040,"Rua Joaquim Honório Pereira Dutra","casa de esquina",Centro,Formosa,GO,61981237821,6136322552,"2021-11-02 09:20:24.506055",,00542552000202,idealsupernfe@gmail.com)	(21,"Ideal Supermecado","Fornecedor de alimentos, e mercadorias.",FORNECEDOR,JURIDICA,73801040,"Rua Joaquim Honório Pereira Dutra",,Centro,Formosa,GO,61981237821,6136322552,"2021-11-02 09:20:24.506055",,00542552000202,idealsupernfe@gmail.com)	21	2021-11-03 19:05:55.579574
45	UPDATE	(20,"Sacolão preço bom","fornecedores e doador de frutas e verduras.",FORNECEDOR,JURIDICA,73802035,"Rua 28","prédio verde, no térreo","Setor Bosque",Formosa,GO,61998213456,6136424991,"2021-11-02 09:13:25.230101",,11078272000120,precisao.contabilidade@hotmail.com)	(20,"Sacolão preço bom","fornecedores e doador de frutas e verduras.",FORNECEDOR,JURIDICA,73802035,"Rua 28",,"Setor Bosque",Formosa,GO,61998213456,6136424991,"2021-11-02 09:13:25.230101",,11078272000120,precisao.contabilidade@hotmail.com)	20	2021-11-03 19:06:51.706791
46	UPDATE	(22,"TEM SUPERMERCADOS SETOR SUL LIMITDA","fornecedor de alimentos, com mercadorias avulsas conforme necessidade.",FORNECEDOR,JURIDICA,73802489,"Avenida Tancredo Neves",,"Setor Sul",Formosa,GO,61998605070,6136425070,"2021-11-02 09:25:28.98667",,26848415000103,thiago@temsupermercados.com.br)	(22,"TEM SUPERMERCADOS SETOR SUL LTDA","fornecedor de alimentos, com mercadorias avulsas conforme necessidade.",FORNECEDOR,JURIDICA,73802489,"Avenida Tancredo Neves",,"Setor Sul",Formosa,GO,61998605070,6136425070,"2021-11-02 09:25:28.98667",,26848415000103,thiago@temsupermercados.com.br)	22	2021-11-03 19:07:24.202527
47	UPDATE	(21,"Ideal Supermercado teste","Fornecedor de alimentos, e mercadorias.",FORNECEDOR,JURIDICA,73801040,"Rua Joaquim Honório Pereira Dutra","casa de esquina",Centro,Formosa,GO,61981237821,6136322552,"2021-11-02 09:20:24.506055",,00542552000202,idealsupernfe@gmail.com)	(21,"Ideal Supermecado","Fornecedor de alimentos, e mercadorias.",FORNECEDOR,JURIDICA,73801040,"Rua Joaquim Honório Pereira Dutra","casa de esquina",Centro,Formosa,GO,61981237821,6136322552,"2021-11-02 09:20:24.506055",,00542552000202,idealsupernfe@gmail.com)	21	2021-11-03 19:27:03.721154
48	DELETE	(21,"Ideal Supermercado teste","Fornecedor de alimentos, e mercadorias.",FORNECEDOR,JURIDICA,73801040,"Rua Joaquim Honório Pereira Dutra","casa de esquina",Centro,Formosa,GO,61981237821,6136322552,"2021-11-02 09:20:24.506055",,00542552000202,idealsupernfe@gmail.com)		21	2021-11-03 19:28:00.135038
49	UPDATE	(19,"Karoline Marques","doadora de brinquedos masculinos.",DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,61928281910,6192902191,"2021-11-01 22:06:26.376496",90184392391,,carol_sizele@gov.com)	(19,"Karoline Marques","doadora de brinquedos masculinos.",DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,61928281910,6192902191,"2021-11-01 22:06:26.376496",90184392391,,carol_sizele@gov.com)	19	2021-11-04 10:50:16.185645
50	INSERT	(23,"Atacadão da cesta básica","fornecedor de cesta básica em todo DF e entorno, fornece cestas de diversos tipos e variedades.",FORNECEDOR,JURIDICA,,"Quadra 5 Lote 16",galpão,"Taguatinga norte",Brasilia,DF,61999111212,6133521558,"2021-11-22 20:03:18.452986",,12678756000173,contato@atacadaocestabasica.com.br)		23	2021-11-22 20:03:18.452986
51	INSERT	(24,"Atacadão da Roupa","doador de roupas, diretamente da fabrica.",DOADOR,JURIDICA,55195009,"Rua Joaquim Nabuco","(Lot Sta Tereza)","Cruz Alta","Santa Cruz do Capibaribe",PE,81981888363,8140420174,"2021-11-24 09:56:53.042621",,17747088000102,sac@atacadaodaroupa.com)		24	2021-11-24 09:56:53.042621
52	UPDATE	(19,"Karoline Marques Nogueira","doadora de brinquedos masculinos.",DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,61928281910,6192902191,"2021-11-01 22:06:26.376496",90184392391,,carol_sizele@gov.com)	(19,"Karoline Marques","doadora de brinquedos masculinos.",DOADOR,FISICA,73801030,"Rua Lindolfo Gonçalves",,Centro,Formosa,GO,61928281910,6192902191,"2021-11-01 22:06:26.376496",90184392391,,carol_sizele@gov.com)	19	2021-12-06 22:17:27.707522
\.


--
-- TOC entry 3047 (class 0 OID 124229)
-- Dependencies: 228
-- Data for Name: log_system; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.log_system (id_log, operacao, valores_velhos, valores_novos, nome_tabela_log, data_hora_log, id_usuario_logado) FROM stdin;
1	INSERT		(3,Doação)	tipo_aquisicao	2021-12-04 11:26:36.368913	\N
2	INSERT		(4,Compra)	tipo_aquisicao	2021-12-04 11:27:01.213121	\N
3	INSERT		(5,Fornecimento)	tipo_aquisicao	2021-12-04 11:27:24.191167	\N
4	INSERT		(6,Devolução)	tipo_aquisicao	2021-12-04 14:19:01.02635	\N
5	UPDATE	(6,Devolução)	(6,"Devolução teste")	tipo_aquisicao	2021-12-04 14:24:18.755953	\N
6	UPDATE	(6,"Devolução teste")	(6,"Devolução teste testando")	tipo_aquisicao	2021-12-04 14:26:07.95734	\N
7	DELETE		(6,"Devolução teste testando")	tipo_aquisicao	2021-12-04 14:50:02.26738	\N
8	INSERT		(7,teste)	tipo_aquisicao	2021-12-04 14:50:28.323855	\N
9	UPDATE	(7,teste)	(7,"teste 123")	tipo_aquisicao	2021-12-04 14:50:35.699915	\N
10	DELETE		(7,"teste 123")	tipo_aquisicao	2021-12-04 14:50:41.233688	\N
11	INSERT		(1,"Cesta básica",1,7,"2021-12-05 16:13:56.222865")	tipo_beneficio	2021-12-05 16:13:56.222865	\N
12	INSERT		(5,"Cesta Basica",1,3,"2021-12-05 16:37:46.823293")	tipo_beneficio	2021-12-05 16:37:46.823293	\N
13	INSERT		(9,aosnoasoa,16,8,"2021-12-05 16:42:53.062304")	tipo_beneficio	2021-12-05 16:42:53.062304	\N
14	INSERT		(11,sfwefwewfewewefwef,1,5,"2021-12-05 16:45:16.292591")	tipo_beneficio	2021-12-05 16:45:16.292591	\N
15	INSERT		(17,"Cesta sfasfafasfafafa",1,7,"2021-12-05 16:56:57.497638")	tipo_beneficio	2021-12-05 16:56:57.497638	\N
16	INSERT		(19,adqdwedwedwedwdw,1,5,"2021-12-05 17:00:11.314014")	tipo_beneficio	2021-12-05 17:00:11.314014	\N
17	INSERT		(20,"Short Masculinos Infantil",16,8,"2021-12-06 08:56:39.762178")	tipo_beneficio	2021-12-06 08:56:39.762178	\N
18	INSERT		(21,fweegregerge,8,7,"2021-12-06 08:57:48.286237")	tipo_beneficio	2021-12-06 08:57:48.286237	\N
19	INSERT		(22,pqowpoeoqwepiqwie,3,1,"2021-12-06 08:58:52.510969")	tipo_beneficio	2021-12-06 08:58:52.510969	\N
20	INSERT		(23,wwwerwerwer,15,8,"2021-12-06 09:17:44.461005")	tipo_beneficio	2021-12-06 09:17:44.461005	\N
21	INSERT		(24,teste,8,7,"2021-12-06 09:18:47.975323")	tipo_beneficio	2021-12-06 09:18:47.975323	\N
22	INSERT		(25,portu,6,1,"2021-12-06 09:21:39.38101")	tipo_beneficio	2021-12-06 09:21:39.38101	\N
23	INSERT		(26,"teste nome",16,3,"2021-12-06 09:25:27.18698")	tipo_beneficio	2021-12-06 09:25:27.18698	\N
24	INSERT		(27,gererrerr,14,1,"2021-12-06 09:33:10.619689")	tipo_beneficio	2021-12-06 09:33:10.619689	\N
25	INSERT		(28,qomdoqwoidmwqoi,8,7,"2021-12-06 09:33:49.578167")	tipo_beneficio	2021-12-06 09:33:49.578167	\N
26	INSERT		(29,BLABLACASD,8,5,"2021-12-06 09:37:21.983528")	tipo_beneficio	2021-12-06 09:37:21.983528	\N
27	INSERT		(30,RHRHRTHRTHRTH,4,7,"2021-12-06 09:39:19.606478")	tipo_beneficio	2021-12-06 09:39:19.606478	\N
28	UPDATE	(29,BLABLACASD,8,5,"2021-12-06 09:37:21.983528")	(29,Carrinhos,11,1,"2021-12-06 09:37:21.983528")	tipo_beneficio	2021-12-06 22:10:37.410085	\N
29	UPDATE	(21,fweegregerge,8,7,"2021-12-06 08:57:48.286237")	(21,"Camisetas masculina",16,8,"2021-12-06 08:57:48.286237")	tipo_beneficio	2021-12-06 22:15:27.027271	\N
30	UPDATE	(22,pqowpoeoqwepiqwie,3,1,"2021-12-06 08:58:52.510969")	(22,pqowpoeoqwepiqwie,3,1,"2021-12-06 08:58:52.510969")	tipo_beneficio	2021-12-06 22:17:55.957752	\N
31	UPDATE	(1,"Cesta básica",1,7,"2021-12-05 16:13:56.222865")	(1,"Cesta básica",1,7,"2021-12-05 16:13:56.222865")	tipo_beneficio	2021-12-07 08:25:38.320003	\N
32	UPDATE	(17,"Cesta sfasfafasfafafa",1,7,"2021-12-05 16:56:57.497638")	(17,"Cesta verduras",1,7,"2021-12-05 16:56:57.497638")	tipo_beneficio	2021-12-07 08:53:55.462576	\N
33	DELETE		(27,gererrerr,14,1,"2021-12-06 09:33:10.619689")	tipo_beneficio	2021-12-07 08:54:07.429766	\N
34	UPDATE	(25,portu,6,1,"2021-12-06 09:21:39.38101")	(25,Cobertores,15,8,"2021-12-06 09:21:39.38101")	tipo_beneficio	2021-12-07 09:00:30.883636	\N
35	DELETE		(22,pqowpoeoqwepiqwie,3,1,"2021-12-06 08:58:52.510969")	tipo_beneficio	2021-12-07 09:00:39.786221	\N
36	UPDATE	(19,adqdwedwedwedwdw,1,5,"2021-12-05 17:00:11.314014")	(19,adqdwedwedwedwdw,1,5,"2021-12-05 17:00:11.314014")	tipo_beneficio	2021-12-07 10:13:58.976348	\N
37	INSERT		(1,23,4,"2021-12-08 09:52:30.248632")	fornecimento_doacao_beneficio	2021-12-08 09:52:30.248632	\N
38	INSERT		(2,23,4,"2021-12-08 09:54:06.605582")	fornecimento_doacao_beneficio	2021-12-08 09:54:06.605582	\N
39	INSERT		(3,23,4,"2021-12-08 09:55:34.608428")	fornecimento_doacao_beneficio	2021-12-08 09:55:34.608428	\N
40	INSERT		(4,22,5,"2021-12-08 09:58:09.268578")	fornecimento_doacao_beneficio	2021-12-08 09:58:09.268578	\N
41	INSERT		(5,23,4,"2021-12-08 10:00:34.245546")	fornecimento_doacao_beneficio	2021-12-08 10:00:34.245546	\N
42	INSERT		(6,22,4,"2021-12-08 10:26:56.470995")	fornecimento_doacao_beneficio	2021-12-08 10:26:56.470995	\N
43	DELETE		(1,23,4,"2021-12-08 09:52:30.248632")	fornecimento_doacao_beneficio	2021-12-08 10:30:05.063545	\N
44	DELETE		(2,23,4,"2021-12-08 09:54:06.605582")	fornecimento_doacao_beneficio	2021-12-08 10:30:05.063545	\N
45	DELETE		(3,23,4,"2021-12-08 09:55:34.608428")	fornecimento_doacao_beneficio	2021-12-08 10:30:05.063545	\N
46	DELETE		(4,22,5,"2021-12-08 09:58:09.268578")	fornecimento_doacao_beneficio	2021-12-08 10:30:05.063545	\N
47	DELETE		(5,23,4,"2021-12-08 10:00:34.245546")	fornecimento_doacao_beneficio	2021-12-08 10:30:05.063545	\N
48	INSERT		(7,23,4,"2021-12-08 10:30:41.156594")	fornecimento_doacao_beneficio	2021-12-08 10:30:41.156594	\N
49	INSERT		(8,23,3,"2021-12-08 10:34:22.27369")	fornecimento_doacao_beneficio	2021-12-08 10:34:22.27369	\N
50	DELETE		(6,22,4,"2021-12-08 10:26:56.470995")	fornecimento_doacao_beneficio	2021-12-08 10:43:09.712457	\N
51	DELETE		(7,23,4,"2021-12-08 10:30:41.156594")	fornecimento_doacao_beneficio	2021-12-08 10:43:09.712457	\N
52	DELETE		(8,23,3,"2021-12-08 10:34:22.27369")	fornecimento_doacao_beneficio	2021-12-08 10:43:09.712457	\N
53	INSERT		(9,23,4,"2021-12-08 10:44:09.482827")	fornecimento_doacao_beneficio	2021-12-08 10:44:09.482827	\N
54	DELETE		(9,23,4,"2021-12-08 10:44:09.482827")	fornecimento_doacao_beneficio	2021-12-08 10:45:50.866861	\N
55	INSERT		(10,23,4,"2021-12-08 10:46:44.961132")	fornecimento_doacao_beneficio	2021-12-08 10:46:44.961132	\N
56	INSERT		(6,"teste descrição insert 1",1,10,5,"2021-12-08 10:46:44.901729")	beneficio	2021-12-08 10:46:44.901729	\N
57	INSERT		(1,1,1,5,"2021-12-08 10:46:45.034088","")	movimentacoes_estoque_beneficios	2021-12-08 10:46:45.034088	\N
58	INSERT		(11,24,3,"2021-12-08 10:52:14.862134")	fornecimento_doacao_beneficio	2021-12-08 10:52:14.862134	\N
59	INSERT		(7,"teste descricao",24,11,5,"2021-12-08 10:52:14.70026")	beneficio	2021-12-08 10:52:14.70026	\N
60	INSERT		(2,24,1,5,"2021-12-08 10:52:14.954289","")	movimentacoes_estoque_beneficios	2021-12-08 10:52:14.954289	\N
61	INSERT		(12,20,3,"2021-12-08 10:55:36.87445")	fornecimento_doacao_beneficio	2021-12-08 10:55:36.87445	\N
62	INSERT		(8,"",29,12,30,"2021-12-08 10:55:36.808373")	beneficio	2021-12-08 10:55:36.808373	\N
63	INSERT		(3,29,1,30,"2021-12-08 10:55:36.98587","")	movimentacoes_estoque_beneficios	2021-12-08 10:55:36.98587	\N
64	INSERT		(13,22,5,"2021-12-08 10:55:37.127531")	fornecimento_doacao_beneficio	2021-12-08 10:55:37.127531	\N
65	INSERT		(9,"",26,13,4,"2021-12-08 10:55:37.069027")	beneficio	2021-12-08 10:55:37.069027	\N
66	INSERT		(4,26,1,4,"2021-12-08 10:55:37.207872","")	movimentacoes_estoque_beneficios	2021-12-08 10:55:37.207872	\N
67	INSERT		(31,"Mochilas escola",11,1,"2021-12-08 10:58:05.820596")	tipo_beneficio	2021-12-08 10:58:05.820596	\N
68	INSERT		(14,20,3,"2021-12-08 10:58:36.034613")	fornecimento_doacao_beneficio	2021-12-08 10:58:36.034613	\N
69	INSERT		(10,"",31,14,5,"2021-12-08 10:58:35.8705")	beneficio	2021-12-08 10:58:35.8705	\N
70	INSERT		(5,31,1,5,"2021-12-08 10:58:36.251706","")	movimentacoes_estoque_beneficios	2021-12-08 10:58:36.251706	\N
71	INSERT		(15,3,4,"2021-12-08 14:08:11.059747")	fornecimento_doacao_beneficio	2021-12-08 14:08:11.059747	\N
72	INSERT		(11,"",29,15,15,"2021-12-08 14:08:10.903658")	beneficio	2021-12-08 14:08:10.903658	\N
73	INSERT		(6,29,1,15,"2021-12-08 14:08:11.289217","")	movimentacoes_estoque_beneficios	2021-12-08 14:08:11.289217	\N
74	INSERT		(16,3,4,"2021-12-08 14:08:11.529355")	fornecimento_doacao_beneficio	2021-12-08 14:08:11.529355	\N
75	INSERT		(12,"",29,16,5,"2021-12-08 14:08:11.479822")	beneficio	2021-12-08 14:08:11.479822	\N
76	INSERT		(7,29,1,5,"2021-12-08 14:08:11.602172","")	movimentacoes_estoque_beneficios	2021-12-08 14:08:11.602172	\N
77	INSERT		(8,29,0,5,"2021-12-08 16:33:36.57436","saida para teste de saldo de estoque")	movimentacoes_estoque_beneficios	2021-12-08 16:33:36.57436	\N
78	INSERT		(9,24,0,3,"2021-12-08 16:37:17.654514","saída efetuada para testar calculo de estoque")	movimentacoes_estoque_beneficios	2021-12-08 16:37:17.654514	\N
79	INSERT		(10,26,1,19,"2021-12-08 16:37:55.755542","saída efetuada para teste")	movimentacoes_estoque_beneficios	2021-12-08 16:37:55.755542	\N
80	INSERT		(11,26,0,5,"2021-12-08 16:38:21.958858","saída efetuada para teste")	movimentacoes_estoque_beneficios	2021-12-08 16:38:21.958858	\N
81	INSERT		(12,31,1,90,"2021-12-08 16:39:10.695265","saída efetuada para teste")	movimentacoes_estoque_beneficios	2021-12-08 16:39:10.695265	\N
82	INSERT		(13,31,0,50,"2021-12-08 16:39:10.695265","saída efetuada para teste")	movimentacoes_estoque_beneficios	2021-12-08 16:39:10.695265	\N
83	INSERT		(14,1,1,350,"2021-12-08 16:40:38.989903","saída efetuada para teste")	movimentacoes_estoque_beneficios	2021-12-08 16:40:38.989903	\N
84	INSERT		(15,1,0,200,"2021-12-08 16:40:38.989903","saída efetuada para teste")	movimentacoes_estoque_beneficios	2021-12-08 16:40:38.989903	\N
85	INSERT		(17,23,4,"2021-12-09 10:03:44.813343")	fornecimento_doacao_beneficio	2021-12-09 10:03:44.813343	\N
87	INSERT		(18,23,4,"2021-12-09 10:06:51.616895")	fornecimento_doacao_beneficio	2021-12-09 10:06:51.616895	\N
89	DELETE		(9,24,0,3,"2021-12-08 16:37:17.654514","saída efetuada para testar calculo de estoque")	movimentacoes_estoque_beneficios	2021-12-09 10:09:06.46234	\N
90	DELETE		(10,26,1,19,"2021-12-08 16:37:55.755542","saída efetuada para teste")	movimentacoes_estoque_beneficios	2021-12-09 10:09:06.46234	\N
91	DELETE		(11,26,0,5,"2021-12-08 16:38:21.958858","saída efetuada para teste")	movimentacoes_estoque_beneficios	2021-12-09 10:09:06.46234	\N
92	DELETE		(12,31,1,90,"2021-12-08 16:39:10.695265","saída efetuada para teste")	movimentacoes_estoque_beneficios	2021-12-09 10:09:06.46234	\N
93	DELETE		(13,31,0,50,"2021-12-08 16:39:10.695265","saída efetuada para teste")	movimentacoes_estoque_beneficios	2021-12-09 10:09:06.46234	\N
94	DELETE		(14,1,1,350,"2021-12-08 16:40:38.989903","saída efetuada para teste")	movimentacoes_estoque_beneficios	2021-12-09 10:09:06.46234	\N
95	DELETE		(15,1,0,200,"2021-12-08 16:40:38.989903","saída efetuada para teste")	movimentacoes_estoque_beneficios	2021-12-09 10:09:06.46234	\N
96	INSERT		(19,20,3,"2021-12-09 10:11:29.635698")	fornecimento_doacao_beneficio	2021-12-09 10:11:29.635698	\N
97	INSERT		(15,"teste insert entrada",29,19,51,"2021-12-09 10:11:29.577406")	beneficio	2021-12-09 10:11:29.577406	\N
98	INSERT		(10,29,1,51,"2021-12-09 10:11:29.828545","")	movimentacoes_estoque_beneficios	2021-12-09 10:11:29.828545	\N
99	INSERT		(11,1,0,2,"2021-12-09 11:26:48.464533","teste de saída de beneficio, sem esta associado a uma entrega")	movimentacoes_estoque_beneficios	2021-12-09 11:26:48.464533	\N
100	INSERT		(12,31,0,2,"2021-12-09 11:30:15.718091","teste de saída de beneficio, sem esta associado a uma entrega")	movimentacoes_estoque_beneficios	2021-12-09 11:30:15.718091	\N
101	INSERT		(13,24,0,5,"2021-12-09 11:32:44.346714","teste de saída de beneficio, sem esta associado a uma entrega")	movimentacoes_estoque_beneficios	2021-12-09 11:32:44.346714	\N
102	INSERT		(14,26,0,1,"2021-12-10 08:26:13.318918","testando saída de beneficio offline")	movimentacoes_estoque_beneficios	2021-12-10 08:26:13.318918	\N
103	INSERT		(15,1,0,1,"2021-12-10 08:30:40.651936","testando saída de beneficio da cesta básica, feijão vencido")	movimentacoes_estoque_beneficios	2021-12-10 08:30:40.651936	\N
104	INSERT		(16,29,0,6,"2021-12-10 08:35:38.953728","saída de 6 carrinhos devido estarem sem a embalagem adequada")	movimentacoes_estoque_beneficios	2021-12-10 08:35:38.953728	\N
105	INSERT		(17,24,1,5,"2021-12-10 08:38:53.466219","entro 5 benefícios de teste, para ver se esta funcionando a entrada offline")	movimentacoes_estoque_beneficios	2021-12-10 08:38:53.466219	\N
106	INSERT		(18,26,1,5,"2021-12-10 08:42:26.883183","entro 5 benefícios de teste nome, para ver se esta funcionando a entrada offline")	movimentacoes_estoque_beneficios	2021-12-10 08:42:26.883183	\N
107	INSERT		(19,24,0,3,"2021-12-10 08:49:36.790976","retirando 3 benefícios de teste, para ver se esta funcionando tudo certo")	movimentacoes_estoque_beneficios	2021-12-10 08:49:36.790976	\N
108	INSERT		(20,29,0,10,"2021-12-10 08:55:24.396639","retirando 10 carrinhos")	movimentacoes_estoque_beneficios	2021-12-10 08:55:24.396639	\N
109	INSERT		(21,1,1,10,"2021-12-10 09:04:43.720026","entrada offline")	movimentacoes_estoque_beneficios	2021-12-10 09:04:43.720026	\N
110	INSERT		(22,31,1,15,"2021-12-10 09:05:37.347957","add 15 novas mochilas")	movimentacoes_estoque_beneficios	2021-12-10 09:05:37.347957	\N
111	INSERT		(23,24,1,10,"2021-12-10 09:06:59.988884","entrada offline de 10 benefícios teste")	movimentacoes_estoque_beneficios	2021-12-10 09:06:59.988884	\N
112	INSERT		(24,26,0,3,"2021-12-10 09:30:23.452068","saiu 3 benefícios")	movimentacoes_estoque_beneficios	2021-12-10 09:30:23.452068	\N
113	INSERT		(25,1,1,15,"2021-12-10 09:31:16.45049","entrou mais 15 off")	movimentacoes_estoque_beneficios	2021-12-10 09:31:16.45049	\N
114	INSERT		(20,20,4,"2021-12-10 09:38:16.562983")	fornecimento_doacao_beneficio	2021-12-10 09:38:16.562983	\N
115	INSERT		(16,"teste de descrição",25,20,10,"2021-12-10 09:38:16.475903")	beneficio	2021-12-10 09:38:16.475903	\N
116	INSERT		(26,25,1,10,"2021-12-10 09:38:16.760002","")	movimentacoes_estoque_beneficios	2021-12-10 09:38:16.760002	\N
117	INSERT		(21,24,5,"2021-12-10 09:45:01.539868")	fornecimento_doacao_beneficio	2021-12-10 09:45:01.539868	\N
118	INSERT		(17,teste,17,21,11,"2021-12-10 09:45:01.487642")	beneficio	2021-12-10 09:45:01.487642	\N
119	INSERT		(27,17,1,11,"2021-12-10 09:45:01.616266","")	movimentacoes_estoque_beneficios	2021-12-10 09:45:01.616266	\N
120	INSERT		(22,22,1,"2021-12-10 10:14:00.655703")	fornecimento_doacao_beneficio	2021-12-10 10:14:00.655703	\N
121	INSERT		(18,"teste y",23,22,1,"2021-12-10 10:14:00.589541")	beneficio	2021-12-10 10:14:00.589541	\N
122	INSERT		(28,23,1,1,"2021-12-10 10:14:00.848139","")	movimentacoes_estoque_beneficios	2021-12-10 10:14:00.848139	\N
123	INSERT		(24,22,4,"2021-12-10 10:15:43.830905")	fornecimento_doacao_beneficio	2021-12-10 10:15:43.830905	\N
124	INSERT		(19,"teste p",19,24,5,"2021-12-10 10:15:43.771237")	beneficio	2021-12-10 10:15:43.771237	\N
125	INSERT		(29,19,1,5,"2021-12-10 10:15:43.943087","")	movimentacoes_estoque_beneficios	2021-12-10 10:15:43.943087	\N
126	INSERT		(25,22,4,"2021-12-10 10:15:44.061969")	fornecimento_doacao_beneficio	2021-12-10 10:15:44.061969	\N
127	INSERT		(20,"teste de insert",9,25,150,"2021-12-10 10:15:44.009349")	beneficio	2021-12-10 10:15:44.009349	\N
128	INSERT		(30,9,1,150,"2021-12-10 10:15:44.140736","")	movimentacoes_estoque_beneficios	2021-12-10 10:15:44.140736	\N
129	INSERT		(26,24,5,"2021-12-10 10:19:15.289371")	fornecimento_doacao_beneficio	2021-12-10 10:19:15.289371	\N
130	INSERT		(21,"testando o refatoramento",20,26,15,"2021-12-10 10:19:15.122603")	beneficio	2021-12-10 10:19:15.122603	\N
131	INSERT		(31,20,1,15,"2021-12-10 10:19:15.375305","")	movimentacoes_estoque_beneficios	2021-12-10 10:19:15.375305	\N
132	INSERT		(32,20,0,1,"2021-12-11 14:12:39.116232","saída para teste")	movimentacoes_estoque_beneficios	2021-12-11 14:12:39.116232	\N
133	INSERT		(33,25,0,1,"2021-12-11 14:13:02.029316","saída de teste")	movimentacoes_estoque_beneficios	2021-12-11 14:13:02.029316	\N
134	INSERT		(34,19,0,2,"2021-12-11 14:13:24.088421",teste)	movimentacoes_estoque_beneficios	2021-12-11 14:13:24.088421	\N
135	INSERT		(35,9,0,1,"2021-12-11 14:13:36.677448",teste)	movimentacoes_estoque_beneficios	2021-12-11 14:13:36.677448	\N
136	INSERT		(36,17,0,1,"2021-12-11 14:13:50.402155",teste)	movimentacoes_estoque_beneficios	2021-12-11 14:13:50.402155	\N
137	INSERT		(37,23,0,1,"2021-12-11 14:14:10.709844",teste)	movimentacoes_estoque_beneficios	2021-12-11 14:14:10.709844	\N
138	INSERT		(38,1,0,2,"2021-12-13 10:42:24.33321","Entrega de benefício efetuada para Cecilia MeirelesAlmeida")	movimentacoes_estoque_beneficios	2021-12-13 10:42:24.33321	\N
139	INSERT		(1,"2021-12-13 10:42:23.996149",10,1,2,10)	entregas_beneficios	2021-12-13 10:42:23.996149	10
140	INSERT		(39,17,0,5,"2021-12-13 10:59:32.460685","Entrega de benefício efetuada para:  Paulo RicardoRocha")	movimentacoes_estoque_beneficios	2021-12-13 10:59:32.460685	\N
141	INSERT		(2,"2021-12-13 10:59:32.296508",19,17,5,19)	entregas_beneficios	2021-12-13 10:59:32.296508	19
142	INSERT		(40,31,0,3,"2021-12-13 10:59:32.658477","Entrega de benefício efetuada para:  Paulo RicardoRocha")	movimentacoes_estoque_beneficios	2021-12-13 10:59:32.658477	\N
143	INSERT		(3,"2021-12-13 10:59:32.605908",19,31,3,19)	entregas_beneficios	2021-12-13 10:59:32.605908	19
144	INSERT		(41,20,0,13,"2021-12-13 11:12:08.232094","Entrega de benefício efetuada para:  Cecilia MeirelesAlmeida")	movimentacoes_estoque_beneficios	2021-12-13 11:12:08.232094	\N
145	INSERT		(4,"2021-12-13 11:12:08.076025",10,20,13,10)	entregas_beneficios	2021-12-13 11:12:08.076025	10
146	INSERT		(42,23,1,5,"2021-12-13 11:29:42.159193","testando se a entrada de beneficio de forma offline esta correta")	movimentacoes_estoque_beneficios	2021-12-13 11:29:42.159193	\N
147	INSERT		(43,1,0,1,"2021-12-15 18:57:27.713587","Entrega de benefício efetuada para:  Cecilia MeirelesAlmeida")	movimentacoes_estoque_beneficios	2021-12-15 18:57:27.713587	\N
148	INSERT		(5,"2021-12-15 18:57:27.574545",10,1,1,37)	entregas_beneficios	2021-12-15 18:57:27.574545	37
149	INSERT		(27,23,3,"2021-12-15 19:37:31.318816")	fornecimento_doacao_beneficio	2021-12-15 19:37:31.318816	\N
150	INSERT		(22,asdasdasdsad,1,27,10,"2021-12-15 19:37:31.25418")	beneficio	2021-12-15 19:37:31.25418	\N
151	INSERT		(44,1,1,10,"2021-12-15 19:37:31.67511","")	movimentacoes_estoque_beneficios	2021-12-15 19:37:31.67511	\N
152	INSERT		(45,1,0,1,"2021-12-15 19:42:02.375547","Entrega de benefício efetuada para:  Cecilia MeirelesAlmeida")	movimentacoes_estoque_beneficios	2021-12-15 19:42:02.375547	\N
153	INSERT		(6,"2021-12-15 19:42:02.201879",10,1,1,37)	entregas_beneficios	2021-12-15 19:42:02.201879	37
154	INSERT		(28,23,1,"2022-02-07 15:19:02.268034")	fornecimento_doacao_beneficio	2022-02-07 15:19:02.268034	\N
155	INSERT		(23,"Teste de cadastro de beneficio",1,28,5,"2022-02-07 15:19:02.177015")	beneficio	2022-02-07 15:19:02.177015	\N
156	INSERT		(46,1,1,5,"2022-02-07 15:19:03.100235","")	movimentacoes_estoque_beneficios	2022-02-07 15:19:03.100235	\N
\.


--
-- TOC entry 3025 (class 0 OID 123731)
-- Dependencies: 205
-- Data for Name: log_usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.log_usuarios (id_log, operacao, valores_novos, valores_velhos, usuario, data_log) FROM stdin;
1	INSERT	(32,32456783290,61777778976,jon@gmail.com,coordenador,adm,9018901,2021-10-09,"Ricardo Almeida")		32	2021-10-09 16:08:10.913814
2	INSERT	(33,34578910356,61777778976,jard@hotmail.com,novo,adm,9018901,2021-10-09,"Cris Paiva")		33	2021-10-09 16:08:17.205347
3	INSERT	(34,34512389032,61444445555,hallad@hotmail.com,"jogador de futebol",comun,123123,2021-10-09,"Cometa halland")		34	2021-10-09 16:09:35.76678
4	DELETE	(34,34512389032,61444445555,hallad@hotmail.com,"jogador de futebol",comun,123123,2021-10-09,"Cometa halland")		34	2021-10-09 16:10:23.344256
5	UPDATE	(33,34578910356,61933332222,rafis@uol.com,"funcionario do departamento da administração",comun,90145901,2021-10-09,"Sou novo usuario")	(33,34578910356,61777778976,jard@hotmail.com,novo,adm,9018901,2021-10-09,"Cris Paiva")	33	2021-10-09 16:12:40.90301
6	UPDATE	(32,32456783290,619444445558,jardel@gremio.com,"colaboorador do bolsa familia",comun,90145901,2021-10-09,"Fernado Helio Rocha")	(32,32456783290,61777778976,jon@gmail.com,coordenador,adm,9018901,2021-10-09,"Ricardo Almeida")	32	2021-10-09 16:15:59.562839
7	UPDATE	(24,19020120921,61288383833,paulo9090@gmail.com,"humorista da praça e nossa",adm,4297f44b13955235245b2497399d7a93,2021-10-06,"Paulinho Gogo Praça e Nossa")	(24,19020120921,61288383833,paulo9090@gmail.com,asionasonasio,adm,4297f44b13955235245b2497399d7a93,2021-10-06,ajsdiasdoisaoi)	24	2021-10-09 16:24:08.482596
8	DELETE	(24,19020120921,61288383833,paulo9090@gmail.com,"humorista da praça e nossa",adm,4297f44b13955235245b2497399d7a93,2021-10-06,"Paulinho Gogo Praça e Nossa")		24	2021-10-09 16:27:48.002366
9	UPDATE	(14,89121821929,61999209292,junior@hotmail.com,"colaborador do CRAS",comun,4297f44b13955235245b2497399d7a93,2021-09-13,"Atalaia Junior ")	(14,89121821929,61999209292,junior@hotmail.com,administrativo,comun,4297f44b13955235245b2497399d7a93,2021-09-13,"Atalaupa Junior")	14	2021-10-09 16:33:19.415591
10	INSERT	(36,12345678911,61993452143,dev_php@gthsystem.com,"desenvolvedor do sistema",adm,4297f44b13955235245b2497399d7a93,2021-10-09,"Desenvolvedor Do Sistema")		36	2021-10-09 16:38:09.624611
11	UPDATE	(25,91209120121,61888888888,usuarioteste_1@email.com,"novo funcionario",adm,4297f44b13955235245b2497399d7a93,2021-10-07,"Novo usuário teste")	(25,91209120121,61888888888,usuarioteste_1@email.com,"novo funcionario",adm,4297f44b13955235245b2497399d7a93,2021-10-07,"Novo usuario teste")	25	2021-10-09 20:35:16.044854
12	DELETE	(36,12345678911,61993452143,dev_php@gthsystem.com,"desenvolvedor do sistema",adm,4297f44b13955235245b2497399d7a93,2021-10-09,"Desenvolvedor Do Sistema")		36	2021-10-10 13:12:08.634214
13	DELETE	(30,12345678900,61933332222,novouser@gmail.com,estagiario,comun,90145901,2021-10-09,"Sou novo usuario")		30	2021-10-10 14:10:42.284336
14	DELETE	(21,90190190112,61728282929,maik@ufc.com,"lutador de boxes mas auxilia na entrega de cestas",comun,4297f44b13955235245b2497399d7a93,2021-09-16,"Maiki Taison rocha junior guedes gomes")		21	2021-10-10 14:11:46.503107
15	INSERT	(37,12345678900,61990901212,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema")		37	2021-10-10 15:38:30.201443
16	UPDATE	(37,12345678900,61990901212,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema")	(37,12345678900,61990901212,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema")	37	2021-10-11 09:33:50.898554
17	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	(37,12345678900,61990901212,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema")	37	2021-10-11 15:47:39.46543
18	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	37	2021-10-11 16:07:16.501664
19	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	37	2021-10-11 16:07:34.581968
20	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	37	2021-10-11 16:07:53.275964
21	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	37	2021-10-11 16:10:25.57172
22	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	37	2021-10-11 16:11:08.717151
23	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	37	2021-10-11 16:38:08.883069
24	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	37	2021-10-11 16:38:25.327793
25	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema do trabalho do projeto de TCC")	37	2021-10-12 09:35:05.358863
26	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	37	2021-10-12 09:36:36.898478
27	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	37	2021-10-12 09:40:26.174049
28	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	37	2021-10-12 09:49:08.12005
29	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	37	2021-10-12 11:25:18.909173
30	DELETE	(11,48956790112,61998124356,wesley@verdao.com,jogador,comun,4297f44b13955235245b2497399d7a93,2021-09-13,"Wesley Palmeiras")		11	2021-10-12 11:26:56.909673
31	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	37	2021-10-13 09:24:14.415688
32	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	37	2021-10-13 19:30:55.017198
33	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	37	2021-10-14 11:24:58.601325
34	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	37	2021-10-15 11:19:13.298162
35	INSERT	(38,09908807700,61994548765,user_p@gmail.com,"novo funcionario do departamento da central de cestas",comun,4297f44b13955235245b2497399d7a93,2021-11-10,"Sou usuario comun")		38	2021-11-10 21:38:50.300688
36	INSERT	(39,00011122233,61999999999,teste@gmail.com,teste,comun,4297f44b13955235245b2497399d7a93,2021-11-25,"teste user")		39	2021-11-25 11:19:44.331295
37	UPDATE	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	(37,12345678900,61999238954,manun_dev@empresa.com,"desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes",adm,4297f44b13955235245b2497399d7a93,2021-10-10,"Manutenção do sistema ")	37	2021-12-14 20:56:06.558229
\.


--
-- TOC entry 3051 (class 0 OID 124263)
-- Dependencies: 232
-- Data for Name: movimentacoes_estoque_beneficios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.movimentacoes_estoque_beneficios (id_movimentacoes_estoque_beneficio, id_tipo_beneficio, tipo_movimentacao, quantidade_mov, data_hora_mov, descricao) FROM stdin;
1	1	1	5	2021-12-08 10:46:45.034088	
2	24	1	5	2021-12-08 10:52:14.954289	
3	29	1	30	2021-12-08 10:55:36.98587	
4	26	1	4	2021-12-08 10:55:37.207872	
5	31	1	5	2021-12-08 10:58:36.251706	
6	29	1	15	2021-12-08 14:08:11.289217	
7	29	1	5	2021-12-08 14:08:11.602172	
8	29	0	5	2021-12-08 16:33:36.57436	saida para teste de saldo de estoque
10	29	1	51	2021-12-09 10:11:29.828545	
11	1	0	2	2021-12-09 11:26:48.464533	teste de saída de beneficio, sem esta associado a uma entrega
12	31	0	2	2021-12-09 11:30:15.718091	teste de saída de beneficio, sem esta associado a uma entrega
13	24	0	5	2021-12-09 11:32:44.346714	teste de saída de beneficio, sem esta associado a uma entrega
14	26	0	1	2021-12-10 08:26:13.318918	testando saída de beneficio offline
15	1	0	1	2021-12-10 08:30:40.651936	testando saída de beneficio da cesta básica, feijão vencido
16	29	0	6	2021-12-10 08:35:38.953728	saída de 6 carrinhos devido estarem sem a embalagem adequada
17	24	1	5	2021-12-10 08:38:53.466219	entro 5 benefícios de teste, para ver se esta funcionando a entrada offline
18	26	1	5	2021-12-10 08:42:26.883183	entro 5 benefícios de teste nome, para ver se esta funcionando a entrada offline
19	24	0	3	2021-12-10 08:49:36.790976	retirando 3 benefícios de teste, para ver se esta funcionando tudo certo
20	29	0	10	2021-12-10 08:55:24.396639	retirando 10 carrinhos
21	1	1	10	2021-12-10 09:04:43.720026	entrada offline
22	31	1	15	2021-12-10 09:05:37.347957	add 15 novas mochilas
23	24	1	10	2021-12-10 09:06:59.988884	entrada offline de 10 benefícios teste
24	26	0	3	2021-12-10 09:30:23.452068	saiu 3 benefícios
25	1	1	15	2021-12-10 09:31:16.45049	entrou mais 15 off
26	25	1	10	2021-12-10 09:38:16.760002	
27	17	1	11	2021-12-10 09:45:01.616266	
28	23	1	1	2021-12-10 10:14:00.848139	
29	19	1	5	2021-12-10 10:15:43.943087	
30	9	1	150	2021-12-10 10:15:44.140736	
31	20	1	15	2021-12-10 10:19:15.375305	
32	20	0	1	2021-12-11 14:12:39.116232	saída para teste
33	25	0	1	2021-12-11 14:13:02.029316	saída de teste
34	19	0	2	2021-12-11 14:13:24.088421	teste
35	9	0	1	2021-12-11 14:13:36.677448	teste
36	17	0	1	2021-12-11 14:13:50.402155	teste
37	23	0	1	2021-12-11 14:14:10.709844	teste
38	1	0	2	2021-12-13 10:42:24.33321	Entrega de benefício efetuada para Cecilia MeirelesAlmeida
39	17	0	5	2021-12-13 10:59:32.460685	Entrega de benefício efetuada para:  Paulo RicardoRocha
40	31	0	3	2021-12-13 10:59:32.658477	Entrega de benefício efetuada para:  Paulo RicardoRocha
41	20	0	13	2021-12-13 11:12:08.232094	Entrega de benefício efetuada para:  Cecilia MeirelesAlmeida
42	23	1	5	2021-12-13 11:29:42.159193	testando se a entrada de beneficio de forma offline esta correta
43	1	0	1	2021-12-15 18:57:27.713587	Entrega de benefício efetuada para:  Cecilia MeirelesAlmeida
44	1	1	10	2021-12-15 19:37:31.67511	
45	1	0	1	2021-12-15 19:42:02.375547	Entrega de benefício efetuada para:  Cecilia MeirelesAlmeida
46	1	1	5	2022-02-07 15:19:03.100235	
\.


--
-- TOC entry 3039 (class 0 OID 124119)
-- Dependencies: 220
-- Data for Name: tipo_aquisicao; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tipo_aquisicao (id_tipo_aquisicao, tipo) FROM stdin;
1	Licitação
3	Doação
4	Compra
5	Fornecimento
\.


--
-- TOC entry 3043 (class 0 OID 124180)
-- Dependencies: 224
-- Data for Name: tipo_beneficio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tipo_beneficio (id_tipo_beneficio, nome_tipo, id_unidade_medida, id_categoria, data_hora) FROM stdin;
5	Cesta Basica	1	3	2021-12-05 16:37:46.823293
9	aosnoasoa	16	8	2021-12-05 16:42:53.062304
11	sfwefwewfewewefwef	1	5	2021-12-05 16:45:16.292591
20	Short Masculinos Infantil	16	8	2021-12-06 08:56:39.762178
23	wwwerwerwer	15	8	2021-12-06 09:17:44.461005
24	teste	8	7	2021-12-06 09:18:47.975323
26	teste nome	16	3	2021-12-06 09:25:27.18698
28	qomdoqwoidmwqoi	8	7	2021-12-06 09:33:49.578167
30	RHRHRTHRTHRTH	4	7	2021-12-06 09:39:19.606478
29	Carrinhos	11	1	2021-12-06 09:37:21.983528
21	Camisetas masculina	16	8	2021-12-06 08:57:48.286237
1	Cesta básica	1	7	2021-12-05 16:13:56.222865
17	Cesta verduras	1	7	2021-12-05 16:56:57.497638
25	Cobertores	15	8	2021-12-06 09:21:39.38101
19	adqdwedwedwedwdw	1	5	2021-12-05 17:00:11.314014
31	Mochilas escola	11	1	2021-12-08 10:58:05.820596
\.


--
-- TOC entry 3037 (class 0 OID 123933)
-- Dependencies: 217
-- Data for Name: unidades_medidas_beneficios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.unidades_medidas_beneficios (id_unidade, sigla, descricao, data_hora) FROM stdin;
1	KG	Peso Kilograma	2021-11-07 16:14:53.404349
2	MM	Comprimento metro	2021-11-07 16:16:22.895043
3	CM	Comprimento centimetros	2021-11-07 16:25:35.434757
4	M²	Área metro	2021-11-08 08:58:56.091692
9	SC	Saca 60kg	2021-11-08 09:02:01.829698
11	UN	Unidade	2021-11-08 09:02:25.684873
12	CT	Cartela	2021-11-08 09:02:37.016965
13	CX	Caixa	2021-11-08 09:02:47.96231
14	DZ	Dúzia	2021-11-08 09:03:14.050236
15	PA	Par	2021-11-08 09:03:23.244869
16	PÇ	Peça	2021-11-08 09:03:35.445969
17	PT	Pacote	2021-11-08 09:03:45.982971
18	RL	Rolo	2021-11-08 09:03:54.41653
19	L 	Litro	2021-11-08 09:04:04.124054
6	M 	Comprimento metro	2021-11-08 09:00:01.485901
10	MG	Miligrama	2021-11-08 09:02:13.502841
7	CM	Comprimento centímetro	2021-11-08 09:00:30.658273
8	G 	Grama	2021-11-08 09:01:16.061235
\.


--
-- TOC entry 3023 (class 0 OID 115425)
-- Dependencies: 203
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuario (id_usuario, cpf_usuario, celular_usuario, email_usuario, cargo_usuario, tipo_usuario, senha_usuario, data_cadastro_usuario, nome_usuario) FROM stdin;
25	91209120121	61888888888	usuarioteste_1@email.com	novo funcionario	adm	4297f44b13955235245b2497399d7a93	2021-10-07	Novo usuário teste
7	90123454612	61992321200	joao@gmail.com	assistente de equipe de referencia	comun	4297f44b13955235245b2497399d7a93	2021-09-13	João romaçal Pereira
10	90112343512	61993245412	paulo@ge.com.br	colaborador departamento central de cestas	comun	4297f44b13955235245b2497399d7a93	2021-09-13	Paulo Ricardo Rocha
12	80912343454	61992101212	roger@gmail.com	goleiro do são paulo	comun	4297f44b13955235245b2497399d7a93	2021-09-13	Rogerio Ceni
15	90234433121	61992983823	yeeda@hotmail.com	administrativo	comun	4297f44b13955235245b2497399d7a93	2021-09-13	Karoline Yeeda
19	90112390432	61998021344	dan@email.com	assistente de equipe de referencia, colaborador da central de cestas em meio período	comun	4297f44b13955235245b2497399d7a93	2021-09-14	Daniel Ribeiro Lopes
20	09943512390	61998321232	teste@email.com	diretor de equipe de referencia, mas auxilia no departamento da central de cestas meio período	comun	4297f44b13955235245b2497399d7a93	2021-09-14	Colaborador teste com um nome bem extenso
38	09908807700	61994548765	user_p@gmail.com	novo funcionario do departamento da central de cestas	comun	4297f44b13955235245b2497399d7a93	2021-11-10	Sou usuario comun
39	00011122233	61999999999	teste@gmail.com	teste	comun	4297f44b13955235245b2497399d7a93	2021-11-25	teste user
37	12345678900	61999238954	manun_dev@empresa.com	desenvolvedor que e responsável por dar manutenção no sistema, e também responsável por dar testes	adm	4297f44b13955235245b2497399d7a93	2021-10-10	Manutenção do sistema 
33	34578910356	61933332222	rafis@uol.com	funcionario do departamento da administração	comun	90145901	2021-10-09	Sou novo usuario
32	32456783290	619444445558	jardel@gremio.com	colaboorador do bolsa familia	comun	90145901	2021-10-09	Fernado Helio Rocha
14	89121821929	61999209292	junior@hotmail.com	colaborador do CRAS	comun	4297f44b13955235245b2497399d7a93	2021-09-13	Atalaia Junior 
\.


--
-- TOC entry 3072 (class 0 OID 0)
-- Dependencies: 206
-- Name: beneficiarios_id_beneficiario_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.beneficiarios_id_beneficiario_seq', 19, true);


--
-- TOC entry 3073 (class 0 OID 0)
-- Dependencies: 229
-- Name: beneficio_id_beneficio_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.beneficio_id_beneficio_seq', 23, true);


--
-- TOC entry 3074 (class 0 OID 0)
-- Dependencies: 214
-- Name: categoria_beneficios_id_categoria_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categoria_beneficios_id_categoria_seq', 8, true);


--
-- TOC entry 3075 (class 0 OID 0)
-- Dependencies: 225
-- Name: entregas_beneficios_id_entrega_beneficio_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.entregas_beneficios_id_entrega_beneficio_seq', 6, true);


--
-- TOC entry 3076 (class 0 OID 0)
-- Dependencies: 210
-- Name: fornecedores_doadores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.fornecedores_doadores_id_seq', 24, true);


--
-- TOC entry 3077 (class 0 OID 0)
-- Dependencies: 221
-- Name: fornecimento_doacao_beneficio_id_fornecimento_doacao_benefi_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.fornecimento_doacao_beneficio_id_fornecimento_doacao_benefi_seq', 28, true);


--
-- TOC entry 3078 (class 0 OID 0)
-- Dependencies: 208
-- Name: log_beneficiarios_id_log_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.log_beneficiarios_id_log_seq', 61, true);


--
-- TOC entry 3079 (class 0 OID 0)
-- Dependencies: 212
-- Name: log_fornecedores_doadores_id_log_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.log_fornecedores_doadores_id_log_seq', 52, true);


--
-- TOC entry 3080 (class 0 OID 0)
-- Dependencies: 227
-- Name: log_system_id_log_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.log_system_id_log_seq', 156, true);


--
-- TOC entry 3081 (class 0 OID 0)
-- Dependencies: 204
-- Name: log_usuarios_id_log_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.log_usuarios_id_log_seq', 37, true);


--
-- TOC entry 3082 (class 0 OID 0)
-- Dependencies: 231
-- Name: movimentacoes_estoque_benefic_id_movimentacoes_estoque_bene_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.movimentacoes_estoque_benefic_id_movimentacoes_estoque_bene_seq', 46, true);


--
-- TOC entry 3083 (class 0 OID 0)
-- Dependencies: 219
-- Name: tipo_aquisicao_id_tipo_aquisicao_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tipo_aquisicao_id_tipo_aquisicao_seq', 7, true);


--
-- TOC entry 3084 (class 0 OID 0)
-- Dependencies: 223
-- Name: tipo_beneficio_id_tipo_beneficio_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tipo_beneficio_id_tipo_beneficio_seq', 31, true);


--
-- TOC entry 3085 (class 0 OID 0)
-- Dependencies: 216
-- Name: unidades_medidas_beneficios_id_unidade_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.unidades_medidas_beneficios_id_unidade_seq', 19, true);


--
-- TOC entry 3086 (class 0 OID 0)
-- Dependencies: 202
-- Name: usuario_id_usuario_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuario_id_usuario_seq', 39, true);


--
-- TOC entry 2832 (class 2606 OID 123847)
-- Name: beneficiarios beneficiarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.beneficiarios
    ADD CONSTRAINT beneficiarios_pkey PRIMARY KEY (id_beneficiario);


--
-- TOC entry 2872 (class 2606 OID 124248)
-- Name: beneficio beneficio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.beneficio
    ADD CONSTRAINT beneficio_pkey PRIMARY KEY (id_beneficio);


--
-- TOC entry 2854 (class 2606 OID 123930)
-- Name: categoria_beneficios categoria_beneficios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria_beneficios
    ADD CONSTRAINT categoria_beneficios_pkey PRIMARY KEY (id_categoria);


--
-- TOC entry 2868 (class 2606 OID 124209)
-- Name: entregas_beneficios entregas_beneficios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entregas_beneficios
    ADD CONSTRAINT entregas_beneficios_pkey PRIMARY KEY (id_entrega_beneficio);


--
-- TOC entry 2844 (class 2606 OID 123904)
-- Name: fornecedores_doadores fornecedores_doadores_cnpj_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fornecedores_doadores
    ADD CONSTRAINT fornecedores_doadores_cnpj_key UNIQUE (cnpj);


--
-- TOC entry 2846 (class 2606 OID 123902)
-- Name: fornecedores_doadores fornecedores_doadores_cpf_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fornecedores_doadores
    ADD CONSTRAINT fornecedores_doadores_cpf_key UNIQUE (cpf);


--
-- TOC entry 2848 (class 2606 OID 123906)
-- Name: fornecedores_doadores fornecedores_doadores_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fornecedores_doadores
    ADD CONSTRAINT fornecedores_doadores_email_key UNIQUE (email);


--
-- TOC entry 2850 (class 2606 OID 123900)
-- Name: fornecedores_doadores fornecedores_doadores_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fornecedores_doadores
    ADD CONSTRAINT fornecedores_doadores_pkey PRIMARY KEY (id);


--
-- TOC entry 2862 (class 2606 OID 124154)
-- Name: fornecimento_doacao_beneficio fornecimento_doacao_beneficio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fornecimento_doacao_beneficio
    ADD CONSTRAINT fornecimento_doacao_beneficio_pkey PRIMARY KEY (id_fornecimento_doacao_beneficio);


--
-- TOC entry 2842 (class 2606 OID 123872)
-- Name: log_beneficiarios log_beneficiarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_beneficiarios
    ADD CONSTRAINT log_beneficiarios_pkey PRIMARY KEY (id_log);


--
-- TOC entry 2852 (class 2606 OID 123918)
-- Name: log_fornecedores_doadores log_fornecedores_doadores_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_fornecedores_doadores
    ADD CONSTRAINT log_fornecedores_doadores_pkey PRIMARY KEY (id_log);


--
-- TOC entry 2870 (class 2606 OID 124239)
-- Name: log_system log_system_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_system
    ADD CONSTRAINT log_system_pkey PRIMARY KEY (id_log);


--
-- TOC entry 2830 (class 2606 OID 123740)
-- Name: log_usuarios log_usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.log_usuarios
    ADD CONSTRAINT log_usuarios_pkey PRIMARY KEY (id_log);


--
-- TOC entry 2874 (class 2606 OID 124270)
-- Name: movimentacoes_estoque_beneficios movimentacoes_estoque_beneficios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movimentacoes_estoque_beneficios
    ADD CONSTRAINT movimentacoes_estoque_beneficios_pkey PRIMARY KEY (id_movimentacoes_estoque_beneficio);


--
-- TOC entry 2858 (class 2606 OID 124124)
-- Name: tipo_aquisicao tipo_aquisicao_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_aquisicao
    ADD CONSTRAINT tipo_aquisicao_pkey PRIMARY KEY (id_tipo_aquisicao);


--
-- TOC entry 2860 (class 2606 OID 124126)
-- Name: tipo_aquisicao tipo_aquisicao_tipo_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_aquisicao
    ADD CONSTRAINT tipo_aquisicao_tipo_key UNIQUE (tipo);


--
-- TOC entry 2864 (class 2606 OID 124188)
-- Name: tipo_beneficio tipo_beneficio_nome_tipo_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_beneficio
    ADD CONSTRAINT tipo_beneficio_nome_tipo_key UNIQUE (nome_tipo);


--
-- TOC entry 2866 (class 2606 OID 124186)
-- Name: tipo_beneficio tipo_beneficio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_beneficio
    ADD CONSTRAINT tipo_beneficio_pkey PRIMARY KEY (id_tipo_beneficio);


--
-- TOC entry 2856 (class 2606 OID 123939)
-- Name: unidades_medidas_beneficios unidades_medidas_beneficios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.unidades_medidas_beneficios
    ADD CONSTRAINT unidades_medidas_beneficios_pkey PRIMARY KEY (id_unidade);


--
-- TOC entry 2834 (class 2606 OID 123854)
-- Name: beneficiarios unique_beneficiarios; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.beneficiarios
    ADD CONSTRAINT unique_beneficiarios UNIQUE (cpf_beneficiario);


--
-- TOC entry 2826 (class 2606 OID 123616)
-- Name: usuario unique_cpf; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT unique_cpf UNIQUE (cpf_usuario);


--
-- TOC entry 2836 (class 2606 OID 123860)
-- Name: beneficiarios unique_cpf_benef; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.beneficiarios
    ADD CONSTRAINT unique_cpf_benef UNIQUE (cpf_beneficiario);


--
-- TOC entry 2838 (class 2606 OID 123858)
-- Name: beneficiarios unique_email_benef; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.beneficiarios
    ADD CONSTRAINT unique_email_benef UNIQUE (email_benef);


--
-- TOC entry 2840 (class 2606 OID 123856)
-- Name: beneficiarios unique_nis_beneficiarios; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.beneficiarios
    ADD CONSTRAINT unique_nis_beneficiarios UNIQUE (nis_beneficiario);


--
-- TOC entry 2828 (class 2606 OID 115431)
-- Name: usuario usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id_usuario);


--
-- TOC entry 2887 (class 2620 OID 123886)
-- Name: beneficiarios logs_trigger_beneficiario; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER logs_trigger_beneficiario AFTER INSERT OR DELETE OR UPDATE ON public.beneficiarios FOR EACH ROW EXECUTE FUNCTION public.gera_logs_beneficiarios();


--
-- TOC entry 2888 (class 2620 OID 123921)
-- Name: fornecedores_doadores logs_trigger_fornecedor_doador; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER logs_trigger_fornecedor_doador AFTER INSERT OR DELETE OR UPDATE ON public.fornecedores_doadores FOR EACH ROW EXECUTE FUNCTION public.gera_logs_fornecedores_doadores();


--
-- TOC entry 2886 (class 2620 OID 123742)
-- Name: usuario logs_trigger_user; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER logs_trigger_user AFTER INSERT OR DELETE OR UPDATE ON public.usuario FOR EACH ROW EXECUTE FUNCTION public.gera_logs_usuarios();


--
-- TOC entry 2893 (class 2620 OID 124276)
-- Name: beneficio trigger_beneficio; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_beneficio AFTER INSERT OR DELETE OR UPDATE ON public.beneficio FOR EACH ROW EXECUTE FUNCTION public.registra_logs_beneficio();


--
-- TOC entry 2892 (class 2620 OID 124226)
-- Name: entregas_beneficios trigger_entrega_beneficios; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_entrega_beneficios AFTER INSERT OR DELETE OR UPDATE ON public.entregas_beneficios FOR EACH ROW EXECUTE FUNCTION public.registra_logs_entregas_beneficios();


--
-- TOC entry 2890 (class 2620 OID 124166)
-- Name: fornecimento_doacao_beneficio trigger_fornecimento_doacao_beneficio; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_fornecimento_doacao_beneficio AFTER INSERT OR DELETE OR UPDATE ON public.fornecimento_doacao_beneficio FOR EACH ROW EXECUTE FUNCTION public.registra_logs_fornecimento_doacao_beneficios();


--
-- TOC entry 2894 (class 2620 OID 124278)
-- Name: movimentacoes_estoque_beneficios trigger_movimentacao_estoque_beneficios; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_movimentacao_estoque_beneficios AFTER INSERT OR DELETE OR UPDATE ON public.movimentacoes_estoque_beneficios FOR EACH ROW EXECUTE FUNCTION public.registra_logs_movimentacoes_estoque_beneficios();


--
-- TOC entry 2889 (class 2620 OID 124145)
-- Name: tipo_aquisicao trigger_tipo_aquisicao; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_tipo_aquisicao AFTER INSERT OR DELETE OR UPDATE ON public.tipo_aquisicao FOR EACH ROW EXECUTE FUNCTION public.registra_logs_tipo_aquisicao();


--
-- TOC entry 2891 (class 2620 OID 124200)
-- Name: tipo_beneficio trigger_tipo_beneficio; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_tipo_beneficio AFTER INSERT OR DELETE OR UPDATE ON public.tipo_beneficio FOR EACH ROW EXECUTE FUNCTION public.registra_logs_tipo_beneficio();


--
-- TOC entry 2875 (class 2606 OID 123848)
-- Name: beneficiarios fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.beneficiarios
    ADD CONSTRAINT fk_usuario FOREIGN KEY (fk_usuario) REFERENCES public.usuario(id_usuario) ON DELETE SET NULL;


--
-- TOC entry 2880 (class 2606 OID 124210)
-- Name: entregas_beneficios id_beneficiario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entregas_beneficios
    ADD CONSTRAINT id_beneficiario FOREIGN KEY (id_beneficiario) REFERENCES public.beneficiarios(id_beneficiario);


--
-- TOC entry 2879 (class 2606 OID 124194)
-- Name: tipo_beneficio id_categoria; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_beneficio
    ADD CONSTRAINT id_categoria FOREIGN KEY (id_categoria) REFERENCES public.categoria_beneficios(id_categoria);


--
-- TOC entry 2884 (class 2606 OID 124254)
-- Name: beneficio id_fornecedor_doador; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.beneficio
    ADD CONSTRAINT id_fornecedor_doador FOREIGN KEY (id_fornecedor_doador) REFERENCES public.fornecimento_doacao_beneficio(id_fornecimento_doacao_beneficio);


--
-- TOC entry 2876 (class 2606 OID 124155)
-- Name: fornecimento_doacao_beneficio id_fornecedores_doadores; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fornecimento_doacao_beneficio
    ADD CONSTRAINT id_fornecedores_doadores FOREIGN KEY (id_fornecedores_doadores) REFERENCES public.fornecedores_doadores(id);


--
-- TOC entry 2877 (class 2606 OID 124160)
-- Name: fornecimento_doacao_beneficio id_tipo_aquisicao; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fornecimento_doacao_beneficio
    ADD CONSTRAINT id_tipo_aquisicao FOREIGN KEY (id_tipo_aquisicao) REFERENCES public.tipo_aquisicao(id_tipo_aquisicao);


--
-- TOC entry 2881 (class 2606 OID 124215)
-- Name: entregas_beneficios id_tipo_beneficio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entregas_beneficios
    ADD CONSTRAINT id_tipo_beneficio FOREIGN KEY (id_tipo_beneficio) REFERENCES public.tipo_beneficio(id_tipo_beneficio);


--
-- TOC entry 2883 (class 2606 OID 124249)
-- Name: beneficio id_tipo_beneficio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.beneficio
    ADD CONSTRAINT id_tipo_beneficio FOREIGN KEY (id_tipo_beneficio) REFERENCES public.tipo_beneficio(id_tipo_beneficio);


--
-- TOC entry 2885 (class 2606 OID 124271)
-- Name: movimentacoes_estoque_beneficios id_tipo_beneficio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movimentacoes_estoque_beneficios
    ADD CONSTRAINT id_tipo_beneficio FOREIGN KEY (id_tipo_beneficio) REFERENCES public.tipo_beneficio(id_tipo_beneficio);


--
-- TOC entry 2878 (class 2606 OID 124189)
-- Name: tipo_beneficio id_unidade_medida; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_beneficio
    ADD CONSTRAINT id_unidade_medida FOREIGN KEY (id_unidade_medida) REFERENCES public.unidades_medidas_beneficios(id_unidade);


--
-- TOC entry 2882 (class 2606 OID 124220)
-- Name: entregas_beneficios id_usuario_responsavel_entrega; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.entregas_beneficios
    ADD CONSTRAINT id_usuario_responsavel_entrega FOREIGN KEY (id_usuario_responsavel_entrega) REFERENCES public.usuario(id_usuario);


-- Completed on 2022-04-24 15:58:03

--
-- PostgreSQL database dump complete
--

