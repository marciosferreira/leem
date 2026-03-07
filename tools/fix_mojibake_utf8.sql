SET NAMES utf8mb4;

SELECT @@character_set_client, @@character_set_connection, @@character_set_results;

UPDATE leem_materia
SET
  titulo = CASE
    WHEN titulo IS NOT NULL AND (titulo LIKE '%Ã%' OR titulo LIKE '%Â%' OR titulo LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(titulo USING latin1) AS BINARY) USING utf8mb4), titulo)
    ELSE titulo
  END,
  descricao = CASE
    WHEN descricao IS NOT NULL AND (descricao LIKE '%Ã%' OR descricao LIKE '%Â%' OR descricao LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(descricao USING latin1) AS BINARY) USING utf8mb4), descricao)
    ELSE descricao
  END,
  texto = CASE
    WHEN texto IS NOT NULL AND (texto LIKE '%Ã%' OR texto LIKE '%Â%' OR texto LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(texto USING latin1) AS BINARY) USING utf8mb4), texto)
    ELSE texto
  END;

UPDATE leem_projeto
SET
  titulo = CASE
    WHEN titulo IS NOT NULL AND (titulo LIKE '%Ã%' OR titulo LIKE '%Â%' OR titulo LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(titulo USING latin1) AS BINARY) USING utf8mb4), titulo)
    ELSE titulo
  END,
  paises = CASE
    WHEN paises IS NOT NULL AND (paises LIKE '%Ã%' OR paises LIKE '%Â%' OR paises LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(paises USING latin1) AS BINARY) USING utf8mb4), paises)
    ELSE paises
  END,
  programas = CASE
    WHEN programas IS NOT NULL AND (programas LIKE '%Ã%' OR programas LIKE '%Â%' OR programas LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(programas USING latin1) AS BINARY) USING utf8mb4), programas)
    ELSE programas
  END,
  descricao = CASE
    WHEN descricao IS NOT NULL AND (descricao LIKE '%Ã%' OR descricao LIKE '%Â%' OR descricao LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(descricao USING latin1) AS BINARY) USING utf8mb4), descricao)
    ELSE descricao
  END,
  slug = CASE
    WHEN slug IS NOT NULL AND (slug LIKE '%Ã%' OR slug LIKE '%Â%' OR slug LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(slug USING latin1) AS BINARY) USING utf8mb4), slug)
    ELSE slug
  END;

UPDATE leem_pesquisa
SET
  titulo = CASE
    WHEN titulo IS NOT NULL AND (titulo LIKE '%Ã%' OR titulo LIKE '%Â%' OR titulo LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(titulo USING latin1) AS BINARY) USING utf8mb4), titulo)
    ELSE titulo
  END,
  autor = CASE
    WHEN autor IS NOT NULL AND (autor LIKE '%Ã%' OR autor LIKE '%Â%' OR autor LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(autor USING latin1) AS BINARY) USING utf8mb4), autor)
    ELSE autor
  END,
  coautor = CASE
    WHEN coautor IS NOT NULL AND (coautor LIKE '%Ã%' OR coautor LIKE '%Â%' OR coautor LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(coautor USING latin1) AS BINARY) USING utf8mb4), coautor)
    ELSE coautor
  END,
  texto = CASE
    WHEN texto IS NOT NULL AND (texto LIKE '%Ã%' OR texto LIKE '%Â%' OR texto LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(texto USING latin1) AS BINARY) USING utf8mb4), texto)
    ELSE texto
  END,
  slug = CASE
    WHEN slug IS NOT NULL AND (slug LIKE '%Ã%' OR slug LIKE '%Â%' OR slug LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(slug USING latin1) AS BINARY) USING utf8mb4), slug)
    ELSE slug
  END;

UPDATE leem_usuario
SET
  nome = CASE
    WHEN nome IS NOT NULL AND (nome LIKE '%Ã%' OR nome LIKE '%Â%' OR nome LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(nome USING latin1) AS BINARY) USING utf8mb4), nome)
    ELSE nome
  END,
  biografia = CASE
    WHEN biografia IS NOT NULL AND (biografia LIKE '%Ã%' OR biografia LIKE '%Â%' OR biografia LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(biografia USING latin1) AS BINARY) USING utf8mb4), biografia)
    ELSE biografia
  END,
  slug = CASE
    WHEN slug IS NOT NULL AND (slug LIKE '%Ã%' OR slug LIKE '%Â%' OR slug LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(slug USING latin1) AS BINARY) USING utf8mb4), slug)
    ELSE slug
  END;

UPDATE leem_cronograma
SET
  texto = CASE
    WHEN texto IS NOT NULL AND (texto LIKE '%Ã%' OR texto LIKE '%Â%' OR texto LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(texto USING latin1) AS BINARY) USING utf8mb4), texto)
    ELSE texto
  END;

UPDATE leem_destaque
SET
  descricao = CASE
    WHEN descricao IS NOT NULL AND (descricao LIKE '%Ã%' OR descricao LIKE '%Â%' OR descricao LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(descricao USING latin1) AS BINARY) USING utf8mb4), descricao)
    ELSE descricao
  END;

UPDATE leem_foto
SET
  titulo = CASE
    WHEN titulo IS NOT NULL AND (titulo LIKE '%Ã%' OR titulo LIKE '%Â%' OR titulo LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(titulo USING latin1) AS BINARY) USING utf8mb4), titulo)
    ELSE titulo
  END,
  tag = CASE
    WHEN tag IS NOT NULL AND (tag LIKE '%Ã%' OR tag LIKE '%Â%' OR tag LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(tag USING latin1) AS BINARY) USING utf8mb4), tag)
    ELSE tag
  END;

UPDATE leem_imagem
SET
  nome = CASE
    WHEN nome IS NOT NULL AND (nome LIKE '%Ã%' OR nome LIKE '%Â%' OR nome LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(nome USING latin1) AS BINARY) USING utf8mb4), nome)
    ELSE nome
  END;


UPDATE leem_video
SET
  titulo = CASE
    WHEN titulo IS NOT NULL AND (titulo LIKE '%Ã%' OR titulo LIKE '%Â%' OR titulo LIKE '%�%')
      THEN COALESCE(CONVERT(CAST(CONVERT(titulo USING latin1) AS BINARY) USING utf8mb4), titulo)
    ELSE titulo
  END;
