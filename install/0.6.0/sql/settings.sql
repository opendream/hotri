drop table if exists %prfx%settings;
create table %prfx%settings (
  library_name varchar(128) null
  ,library_image_url text null
  ,use_image_flg char(1) not null
  ,library_hours varchar(128) null
  ,library_phone varchar(40) null
  ,library_url text null
  ,opac_url text null
  ,session_timeout smallint not null
  ,items_per_page tinyint not null
  ,version varchar(10) not null
  ,themeid smallint not null
  ,purge_history_after_months smallint not null
  ,block_checkouts_when_fines_due char(1) not null
  ,hold_max_days smallint not null
  ,locale varchar(8) not null
  ,charset varchar(20) null
  ,html_lang_attr varchar(8) null
  ,font_normal varchar(20) null
  ,font_bold varchar(20) null
  ,font_oblique varchar(20) null
)
  TYPE=MyISAM
;
