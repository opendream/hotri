/* This file is part of the YAZ toolkit.
 * Copyright (C) 1995-2009 Index Data
 * See the file LICENSE for details.
 */

#include <stdlib.h>
#include <stdio.h>

#include <yaz/wrbuf.h>
#include <yaz/test.h>

static void tstwrbuf(void)
{
    int step;
    WRBUF wr = wrbuf_alloc();

    YAZ_CHECK(wr);

    wrbuf_destroy(wr);

    wr = wrbuf_alloc();

    YAZ_CHECK(wr);

    for (step = 1; step < 65; step++)
    {
        int i, j, k;
        int len;
        char buf[64];
        char *cp;
        for (j = 1; j<step; j++)
        {
            for (i = 0; i<j; i++)
                buf[i] = i+1;
            buf[i] = '\0';
            wrbuf_puts(wr, buf);
        }
        
        cp = wrbuf_buf(wr);
        len = wrbuf_len(wr);
        YAZ_CHECK(len == step * (step-1) / 2);
        k = 0;
        for (j = 1; j<step; j++)
            for (i = 0; i<j; i++)
            {
                YAZ_CHECK(cp[k] == i+1);
                k++;
            }
        wrbuf_rewind(wr);
    }
    wrbuf_destroy(wr);
}

int main (int argc, char **argv)
{
    YAZ_CHECK_INIT(argc, argv);
    tstwrbuf();
    YAZ_CHECK_TERM;
}

/*
 * Local variables:
 * c-basic-offset: 4
 * c-file-style: "Stroustrup"
 * indent-tabs-mode: nil
 * End:
 * vim: shiftwidth=4 tabstop=8 expandtab
 */

