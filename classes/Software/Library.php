<?php

/**
 * A generic software library class
 * @author @oplik0
 * @version 0.1
 * @package php-exam
 */
require_once(__DIR__ . "/Software.php");

class Library extends Software
{
    protected string $language;
    protected string $registry;
    protected bool $isSemVer;
    public function __construct(string $name = "unknown", string|array $versions = "0.0.0", string $author = "unknown", string $license = "unknown", string $language = "unknown", string $registry = 'http://localhost')
    {
        parent::__construct($name, $versions, $author, $license);
        $this->language = $language;
        $this->registry = $registry;
        $this->isSemVer = true;
        foreach ($this->versions as $version) {
            if (!preg_match("/^((([0-9]+)\.([0-9]+)\.([0-9]+)(?:-([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?)(?:\+([0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*))?)$/", $version)) {
                $this->isSemVer = false;
                break;
            }
        }
    }
    public function getLanguage(): string
    {
        return $this->language;
    }
    public function getRegistry(): string
    {
        return $this->registry;
    }
    public function isSemVer(): bool
    {
        return $this->isSemVer;
    }
    public function setLanguage(string $language): void
    {
        if (!in_array($language, self::SUPPORTED_LANGUAGES)) {
            throw new Exception('Language is not supported');
        }
        $this->language = $language;
    }
    public function setRegistry(string $registry): void
    {
        if (preg_match("https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)", $registry)) {
            $this->registry = $registry;
        }
    }
    public function isRegistryUp(): bool
    {
        $curl_session = curl_init($this->registry);
        curl_setopt($curl_session, CURLOPT_HEADER, true);
        curl_exec($curl_session);
        $status = curl_getinfo($curl_session, CURLINFO_RESPONSE_CODE);
        curl_close($curl_session);
        if ($status === 200) {
            return true;
        }
        return false;
    }
    public function __toString(): string
    {
        $usesSemVer = ($this->isSemVer) ? "uses" : "does not use";
        return str_replace("]", ", for $this->language, using $this->registry registry, $usesSemVer semantic versioning]", parent::__toString());
    }
    const SUPPORTED_LANGUAGES = array(
        "FoxPro",
        "Fox",
        "Pro",
        "VFP",
        "VFPA",
        "Enterprise",
        "script",
        "4D",
        "4th",
        "Dimension",
        "ABAP",
        "ActionScript",
        "AS1",
        "AS2",
        "AS3",
        "Ada",
        "Agilent",
        "VEE",
        "Algol",
        "Angelscript",
        "Apex",
        "APL",
        "Applescript",
        "Arc",
        "AspectJ",
        "Assembly",
        "Assembly",
        "language",
        "ATLAS",
        "AutoHotkey",
        "AHK",
        "AutoIt",
        "AutoLISP",
        "Automator",
        "Avenue",
        "Awk",
        "Mawk",
        "Gawk",
        "Nawk",
        "B4X",
        "Ballerina",
        "Bash",
        "BBC",
        "BASIC",
        "bc",
        "BCPL",
        "BlitzMax",
        "BlitzBasic",
        "Blitz",
        "Basic",
        "Boo",
        "Bourne",
        "shell",
        "sh",
        "Brainfuck",
        "C#",
        "C-Sharp",
        "C",
        "Sharp",
        "CSharp",
        "CSharp.NET",
        "C#.NET",
        "C++",
        "C++/CLI",
        "C-Omega",
        "Objective-C",
        "Caml",
        "Ceylon",
        "CFML",
        "ColdFusion",
        "computer",
        "game",
        "computer",
        "graphics",
        "christ",
        "CHILL",
        "CIL",
        "CLLE",
        "Clarion",
        "VBA",
        "VB6",
        "Clipper",
        "CLIPS",
        "Clojure",
        "ClojureScript",
        "CLU",
        "COBOL",
        "Cobra",
        "CoffeeScript",
        "COMAL",
        "Common",
        "Lisp",
        "crystallang",
        "cT",
        "Curl",
        "3-D",
        "programming",
        "DTrace",
        "dlang",
        "Dart",
        "DCL",
        "DBL",
        "Synergy/DE",
        "DIBOL",
        "Dylan",
        "ECMAScript",
        "EGL",
        "Eiffel",
        "Elixir",
        "Elm",
        "Emacs",
        "Lisp",
        "Elips",
        "Emerald",
        "Erlang",
        "Etoys",
        "Euphoria",
        "EXEC",
        "F#",
        "F-Sharp",
        "FSharp",
        "F",
        "Sharp",
        "Factor",
        "Falcon",
        "Fantom",
        "Forth",
        "Fortran",
        "Fortress",
        "FreeBASIC",
        "Gambas",
        "GAMS",
        "GLSL",
        "GML",
        "GameMaker",
        "Language",
        "GNU",
        "Octave",
        "Go",
        "Golang",
        "Gosu",
        "Groovy",
        "GPATH",
        "GSQL",
        "Groovy++",
        "Hack",
        "Harbour",
        "Haskell",
        "Haxe",
        "Heron",
        "HPL",
        "HyperTalk",
        "-corba",
        "-interface)",
        "Idris",
        "Inform",
        "Informix-4GL",
        "INTERCAL",
        "Io",
        "Ioke",
        "J#",
        "JADE",
        "Java",
        "JavaFX",
        "Script",
        "JavaScript",
        "JS",
        "SSJS",
        "JScript",
        "JScript.NET",
        "Julia",
        "Julialang",
        "julia-lang",
        "Korn",
        "shell",
        "ksh",
        "Kotlin",
        "LabVIEW",
        "Ladder",
        "Logic",
        "Lasso",
        "Limbo",
        "Lingo",
        "Lisp",
        "Revolution",
        "LiveCode",
        "LotusScript",
        "LPC",
        "Lua",
        "LuaJIT",
        "Lustre",
        "M4",
        "Magik",
        "Malbolge",
        "MANTIS",
        "Maple",
        "MATLAB",
        "Max/MSP",
        "MAXScript",
        "MDX",
        "MEL",
        "Mercury",
        "Miva",
        "ML",
        "Modula-2",
        "Modula-3",
        "Monkey",
        "MOO",
        "Moto",
        "MQL4",
        "MQL5",
        "MS-DOS",
        "batch",
        "MUMPS",
        "NATURAL",
        "Nemerle",
        "NetLogo",
        "Nim",
        "Nimrod",
        "NQC",
        "NSIS",
        "NXT-G",
        "Oberon",
        "Object",
        "Rexx",
        "Objective-C",
        "objc",
        "obj-c",
        "Objective",
        "Caml",
        "OCaml",
        "Occam",
        "OpenCL",
        "Progress",
        "Progress",
        "4GL",
        "ABL",
        "Advanced",
        "Business",
        "Language",
        "OpenEdge",
        "OPL",
        "Oxygene",
        "Oz",
        "Paradox",
        "Perl",
        "PHP",
        "Pike",
        "Palm",
        "Pilot",
        "programming",
        "PL/1",
        "PL/I",
        "PL/SQL",
        "Pliant",
        "Pony",
        "PostScript",
        "PS",
        "POV-Ray",
        "PowerBasic",
        "PowerScript",
        "PowerShell",
        "sketchbook",
        "Programming",
        "Without",
        "Coding",
        "Technology",
        "PWCT",
        "Prolog",
        "Pure",
        "Data",
        "PD",
        "PureBasic",
        "Python",
        "Q",
        "Racket",
        "Perl",
        "6",
        "Raku",
        "REBOL",
        "20%)",
        "REXX",
        "Ring",
        "-role)",
        "RPGLE",
        "ILERPG",
        "RPGIV",
        "RPGIII",
        "RPG400",
        "RPGII",
        "RPG4",
        "Ruby",
        "Rust",
        "Rustlang",
        "SAS",
        "Sather",
        "Scala",
        "Scratch",
        "sed",
        "Seed7",
        "Simula",
        "Simulink",
        "Small",
        "Basic",
        "Smalltalk",
        "Smarty",
        "Snap!",
        "SNOBOL",
        "Solidity",
        "SPARK",
        "SPSS",
        "SQL",
        "SQR",
        "Squeak",
        "Squirrel",
        "Standard",
        "ML",
        "SML",
        "Stata",
        "Structured",
        "Text",
        "Suneido",
        "Swift",
        "TACL",
        "Tcl/Tk",
        "Tcl",
        "tcsh",
        "Tex",
        "thinBasic",
        "T-SQL",
        "Transact-SQL",
        "TSQL",
        "TypeScript",
        "TS",
        "Uniface",
        "Vala",
        "Genie",
        "VBScript",
        "Verilog",
        "VHDL",
        "WASM`",
        "WebAssembly",
        "WebDNA",
        "Whitespace",
        "Wolfram",
        "X10",
        "xBase",
        "XBase++",
        "XC",
        "Xen",
        "REALbasic",
        "Xojo",
        "XPL",
        "XQuery",
        "XSLT",
        "Xtend",
        "yacc",
        "Yorick",
        "Z",
        "shell",
        "zsh",
        "Zig",
        "zlang"
    );
}