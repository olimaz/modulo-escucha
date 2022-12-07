alter table catalogos.cat_item
    add pendiente_revisar int default 2;

alter table catalogos.cat_item
    add fh_creacion timestamp default current_timestamp;

create index cat_item_pendiente_revisar_index
    on catalogos.cat_item (pendiente_revisar);

