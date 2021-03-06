######################################################################
# Copyright (C) 2012 Hewlett-Packard Development Company, L.P.
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# version 2 as published by the Free Software Foundation.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License along
# with this program; if not, write to the Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
######################################################################
TOP = ../../../..
include $(TOP)/Makefile.conf
SRCDIR = ..

TESTDIR = $(TOP)/src/testing/lib/c
TESTLIB = -L$(TESTDIR) -l focunit -I $(TESTDIR)
LOCAL_CFLAGS = $(DB_CFLAGS) $(REPO_CFLAGS) $(ALL_CFLAGS) \
               $(TESTLIB) -I$(SRCDIR) -I../ -lcunit
EXE = testlibs

OBJS = test_fossconfig.o    \
       test_fossscheduler.o \
       test_libfossdb.o     \
       test_libfossdbmanager.o \

all: test
test: $(EXE)
	@echo "make library tests"
	./$(EXE)

coverage: $(OBJS) libfossology_cov.a $(EXE).c $(FOLIB)
	@echo "make library coverage tests"
	$(CC) $(EXE).c -o $(EXE) $(OBJS) $(SRCDIR)/libfossology_cov.a $(LOCAL_CFLAGS) $(COV_CFLAGS)
	./$(EXE)
	lcov --directory $(SRCDIR) --capture --output-file cov.txt; \
	genhtml -o results cov.txt

$(EXE): $(OBJS) libfossology.a $(EXE).c $(FOLIB)
	$(CC) $(EXE).c -o $@ $(OBJS) $(SRCDIR)/libfossology.a $(LOCAL_CFLAGS)

$(OBJS): %.o: %.c
	$(CC) -c $(LOCAL_CFLAGS) $<

libfossology.a:
	$(MAKE) -C $(SRCDIR) $@

libfossology_cov.a:
	$(MAKE) -C $(SRCDIR) $@

#####################
# other build rules #
#####################

clean:
	@echo "make library tests clean"
	rm -rf $(EXE) *.o *.g *.xml *.txt *.gcda *.gcno *.a results

install:
	@echo "make library tests nothing to install"

uninstall:
	@echo "make library tests nothing to uninstall"

.PHONY: all install uninstall clean test
include $(TOP)/Makefile.deps
